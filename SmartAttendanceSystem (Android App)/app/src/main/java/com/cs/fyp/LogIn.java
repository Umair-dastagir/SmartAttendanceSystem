package com.cs.fyp;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.PopupWindow;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.cs.fyp.api.RetrofitClient;
import com.cs.fyp.models.User;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LogIn extends AppCompatActivity {

    private EditText email;
    private EditText password;

    private TextView forgotPassword;

    private Button signInBtn;
    Button exit;

    private ProgressBar progressBar;

    String emailPattern = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";

    private Context mContext;
    private Activity mActivity;

    private RelativeLayout mRelativeLayout;
    private Button mButton;
    TextView txtcontact;

    private PopupWindow mPopupWindow;



    @Override
    public void onBackPressed() {
    }

    public void setupUI(View view) {

        // Set up touch listener for non-text box views to hide keyboard.
        if (!(view instanceof EditText)) {
            view.setOnTouchListener(new View.OnTouchListener() {
                @SuppressLint("ClickableViewAccessibility")
                public boolean onTouch(View v, MotionEvent event) {
                    hideSoftKeyboard(LogIn.this);
                    return false;
                }
            });
        }

        //If a layout container, iterate over children and seed recursion.
        if (view instanceof ViewGroup) {
            for (int i = 0; i < ((ViewGroup) view).getChildCount(); i++) {
                View innerView = ((ViewGroup) view).getChildAt(i);
                setupUI(innerView);
            }
        }
    }
    public static void hideSoftKeyboard(Activity activity) {
        InputMethodManager inputMethodManager =
                (InputMethodManager) activity.getSystemService(
                        Activity.INPUT_METHOD_SERVICE);
        View focusedView= activity.getCurrentFocus();
        if(focusedView != null)
        {
            //Error solved (Edit text keyboard hide)
            assert inputMethodManager != null;
            inputMethodManager.hideSoftInputFromWindow(focusedView.getWindowToken(),InputMethodManager.HIDE_NOT_ALWAYS);

        }

    }

    @Override
    protected void onStart() {
        setupUI(mRelativeLayout);
        super.onStart();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_log_in);

        mContext = getApplicationContext();
        mActivity = LogIn.this;
        mRelativeLayout = (RelativeLayout) findViewById(R.id.r1);
        txtcontact = findViewById(R.id.contact);

        email = findViewById(R.id.editText_email);
        password = findViewById(R.id.editText_password);

        signInBtn = findViewById(R.id.button_sig_in);
        progressBar = findViewById(R.id.sign_in_progressBar);
        exit = findViewById(R.id.exit);


        progressBar.setVisibility(View.INVISIBLE);

        /*txtcontact.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //LayoutInflater inflater = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);

                // Inflate the custom layout/view
                View customView = inflater.inflate(R.layout.popup_layout,null,false);

                mPopupWindow = new PopupWindow(
                        customView,
                        RelativeLayout.LayoutParams.WRAP_CONTENT,
                        RelativeLayout.LayoutParams.WRAP_CONTENT
                );
                if(Build.VERSION.SDK_INT>=21){
                    mPopupWindow.setElevation(5.0f);
                }
                ImageButton closeButton = (ImageButton) customView.findViewById(R.id.ib_close);
                closeButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        // Dismiss the popup window
                        mPopupWindow.dismiss();
                    }
                });
                TextView txtlink = findViewById(R.id.link);
                txtlink.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        Intent myWebLink = new Intent(android.content.Intent.ACTION_VIEW);
                        myWebLink.setData(Uri.parse("http://www.buitms.edu.pk"));
                        startActivity(myWebLink);
                    }
                });
                mPopupWindow.showAtLocation(mRelativeLayout, Gravity.CENTER,0,0);
            }
        });*/

        exit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finishAffinity();
            }
        });

        email.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                checkInputs();
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
        password.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                checkInputs();
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });


        signInBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String em = email.getText().toString().trim();
                String pass = password.getText().toString().trim();

                if(em.matches(emailPattern)){

                Call<ResponseBody> call = RetrofitClient.getInstance().getApi().userLogin(em, pass);

                call.enqueue(new Callback<ResponseBody>() {
                    @Override
                    public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
//                        Toast.makeText(getApplicationContext(),"working",Toast.LENGTH_LONG).show();
                        progressBar.setVisibility(View.VISIBLE) ;
                        signInBtn.setEnabled(false);
                        signInBtn.setTextColor(Color.argb(50,255,255,255));

                        try {
                            String s = response.body().string();
                            try {
                                JSONObject jsonObject = new JSONObject(s);
                                String status = jsonObject.getString("status");
                                String msg = jsonObject.getString("message");
                                String data = jsonObject.getString("data");

//                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();

                                if(status.equals("true")) {
                                    JSONObject jsonObject1 = new JSONObject(data);
                                    String name = jsonObject1.getString("name");
                                    String id = jsonObject1.getString("id");
                                    String email = jsonObject1.getString("email");

                                    User user = new User(id, name, email);
                                    user.setId(id);

                                    Intent intent = new Intent(LogIn.this, Courses.class);
                                    intent.putExtra("student_id",id);
                                    intent.putExtra("student_name",name);
                                    startActivity(intent);
                                    finish();
                                }
                                else{
                                    Toast.makeText(getBaseContext(),"Invalid email or password",Toast.LENGTH_SHORT).show();
                                    progressBar.setVisibility(View.INVISIBLE);
                                }

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }


                        } catch (IOException e) {
                            e.printStackTrace();
                        }


                    }
                    @Override
                    public void onFailure(Call<ResponseBody> call, Throwable t) {
                        progressBar.setVisibility(View.INVISIBLE) ;
                        signInBtn.setEnabled(true);
                        signInBtn.setTextColor(Color.rgb( 255,255,255));
                        Toast.makeText(getApplicationContext(),t.getMessage(),Toast.LENGTH_LONG).show();
                    }
            });
                }
                else{Toast.makeText(getBaseContext(),"Please fill all of the fields",Toast.LENGTH_SHORT).show();}
        }


    });



    /*private void checkInputs() {
        if(!TextUtils.isEmpty(email.getText())){
            if(!TextUtils.isEmpty(password.getText())) {
                signInBtn.setEnabled(true);
                signInBtn.setTextColor(Color.rgb(255,255,255));

            }else{
                signInBtn.setEnabled(false);
                signInBtn.setTextColor(Color.argb(50,255,255,255));
            }
        }else{
            signInBtn.setEnabled(false);
            signInBtn.setTextColor(Color.argb(50,255,255,255));
        }
    }
    private void checkEmailAndPassword() {
        if(email.getText().toString().matches(emailPattern)){



                progressBar.setVisibility(View.VISIBLE) ;
                signInBtn.setEnabled(false);
                signInBtn.setTextColor(Color.argb(50,255,255,255));

                /*firebaseAuth.signInWithEmailAndPassword(email.getText().toString(), password.getText().toString())
                        .addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                            @Override
                            public void onComplete(@NonNull Task<AuthResult> task) {
                                if(task.isSuccessful()){
                                    mainIntent();
                                }else{
                                    progressBar.setVisibility(View.INVISIBLE) ;
                                    signInBtn.setEnabled(true);
                                    signInBtn.setTextColor(Color.rgb( 255,255,255));
                                    String error = task.getException().getMessage();
                                    Toast.makeText(LogIn.this, error, Toast.LENGTH_SHORT).show();
                                }
                            }
                        });
        }else{
                Toast.makeText(LogIn.this, "Incorrect email or password!", Toast.LENGTH_SHORT).show();
            }*/
    }

    private void checkInputs() {
        if(!TextUtils.isEmpty(email.getText())){
            if(!TextUtils.isEmpty(password.getText())) {
                signInBtn.setEnabled(true);
                signInBtn.setTextColor(Color.rgb(255,255,255));

            }else{
                signInBtn.setEnabled(false);
                signInBtn.setTextColor(Color.argb(50,255,255,255));
            }
        }else{
            signInBtn.setEnabled(false);
            signInBtn.setTextColor(Color.argb(50,255,255,255));
        }
    }
}

