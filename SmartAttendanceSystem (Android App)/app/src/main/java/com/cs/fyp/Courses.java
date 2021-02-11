package com.cs.fyp;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class Courses extends AppCompatActivity {


    private static final String URL_DATA = "http://172.24.9.195/SmartAttendanceSystem/api/student/Account/fetch_user_courses?";
    private RecyclerView recyclerView;
    private List<CourseItems> listItems;
    private RecyclerView.Adapter adapter;
    private String studentId;
    private String studentName;

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()){
            case R.id.logout:
                this.finish();
                Intent i = new Intent(Courses.this, LogIn.class);
                i.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY);
                startActivity(i);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_courses);

        recyclerView = findViewById(R.id.recyclerView);
        recyclerView.setHasFixedSize(true);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        listItems = new ArrayList<>();

        if (savedInstanceState == null) {
            Bundle extras = getIntent().getExtras();
            if(extras == null) {
                studentId= null;
                studentName = null;
            } else {
                studentId= extras.getString("student_id");
                studentName= extras.getString("student_name");
            }
        } else {
            studentId= (String) savedInstanceState.getSerializable("student_id");
            studentName= (String) savedInstanceState.getSerializable("student_name");
        }

        Toast.makeText(getApplicationContext(),"Welcome Back "+studentName, Toast.LENGTH_LONG).show();

        loadRecyclerViewData();

//        adapter = new CourseAdapter(listItems, getApplicationContext());
//        recyclerView.setAdapter(adapter);

    }

    @Override
    public void onBackPressed() {
    }

    private void loadRecyclerViewData() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Loading Data");
        progressDialog.show();

        StringRequest stringRequest = new StringRequest(
                Request.Method.GET,
                URL_DATA + "student_id=" +studentId, new com.android.volley.Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

                progressDialog.dismiss();

                try {
                    JSONObject jsonObject = new JSONObject(response);
                    JSONArray jsonArray = jsonObject.getJSONArray("data");

                    for (int i=0;i<jsonArray.length();i++) {

                        JSONObject jsonObject1 = jsonArray.getJSONObject(i);

                        CourseItems item = new CourseItems(
                                jsonObject1.getString("course_name"),
                                jsonObject1.getString("instructor_name"),
                                studentId,
                                jsonObject1.getString("instructor_id"),
                                jsonObject1.getString("class_id"),
                                jsonObject1.getString("assigned_id"),
                                jsonObject1.getString("type"),
                                jsonObject1.getString("total_classes"),
                                jsonObject1.getString("attended_classes"),
                                jsonObject1.getString("percentage"),
                                jsonObject1.getString("course_id"),
                                studentName
                        );
                        listItems.add(item);
                        //Toast.makeText(getApplicationContext(),item.getText1(), Toast.LENGTH_LONG).show();
                    }

                    adapter = new CourseAdapter(listItems, getApplicationContext());
                    recyclerView.setAdapter(adapter);



                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
        }, new com.android.volley.Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressDialog.dismiss();
                Toast.makeText(getApplicationContext(),"Error occurred: "+error.getMessage(), Toast.LENGTH_LONG).show();
            }
        });

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }

}
