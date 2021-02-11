package com.cs.fyp;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.os.Vibrator;
import android.util.SparseArray;
import android.view.MenuItem;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.cs.fyp.api.RetrofitClient;
import com.google.android.gms.vision.CameraSource;
import com.google.android.gms.vision.Detector;
import com.google.android.gms.vision.barcode.Barcode;
import com.google.android.gms.vision.barcode.BarcodeDetector;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class QrScanner extends AppCompatActivity {

    SurfaceView surfaceView;
    TextView textResult;
    BarcodeDetector barcodeDetector;
    CameraSource cameraSource;
    final int REQUEST_CAMERA_PERMISSION_ID = 1001;
    String studentId;
    String instructorId;
    String classId;
    String assignedId;
    String courseId;
    String code;
    String sname;

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()){
            case android.R.id.home:
                this.finish();
                Intent i = new Intent(QrScanner.this, Courses.class);
                i.putExtra("student_id",studentId);
                i.putExtra("student_name", sname);
                i.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY);
                startActivity(i);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        switch (requestCode) {
            case REQUEST_CAMERA_PERMISSION_ID: {
                if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    if (ActivityCompat.checkSelfPermission(this, Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED) {
                        return;
                    }
                    try {
                        cameraSource.start(surfaceView.getHolder());
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }
            } break;
        }
    }
    @Override
    public void onBackPressed() {
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_qr);

        getSupportActionBar().setDisplayShowHomeEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        surfaceView = findViewById(R.id.cameraPreview);
        textResult = findViewById(R.id.textResult);

        if (savedInstanceState == null) {
            Bundle extras = getIntent().getExtras();
            if(extras == null) {
                studentId= null;
            } else {
                studentId= extras.getString("student_id");
                instructorId= extras.getString("ins_id");
                classId = extras.getString("class_id");
                assignedId = extras.getString("assigned_id");
                courseId = extras.getString("course_id");
                sname = extras.getString("student_name");
                //Toast.makeText(getApplicationContext(), classId, Toast.LENGTH_LONG).show();
            }
        } else {
            studentId= (String) savedInstanceState.getSerializable("student_id");
            instructorId= (String) savedInstanceState.getSerializable("ins_id");
            classId= (String) savedInstanceState.getSerializable("class_id");
            assignedId = (String) savedInstanceState.getSerializable("assigned_id");
            courseId = (String) savedInstanceState.getSerializable("course_id");
            sname = (String) savedInstanceState.getSerializable("student_name");
           // Toast.makeText(getApplicationContext(), classId, Toast.LENGTH_LONG).show();
        }



        barcodeDetector = new BarcodeDetector.Builder(this)
                .setBarcodeFormats(Barcode.QR_CODE)
                .build();


        cameraSource = new CameraSource.Builder(this, barcodeDetector).setRequestedPreviewSize(680, 500).
                setAutoFocusEnabled(true).build();

        surfaceView.getHolder().addCallback(new SurfaceHolder.Callback() {
            @Override
            public void surfaceCreated(SurfaceHolder holder) {
                if (ActivityCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED) {
                    ActivityCompat.requestPermissions(QrScanner.this,
                            new String[] {Manifest.permission.CAMERA}, REQUEST_CAMERA_PERMISSION_ID);
                    return;
                }
                try {
                    cameraSource.start(surfaceView.getHolder());
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }



            @Override
            public void surfaceChanged(SurfaceHolder holder, int format, int width, int height) {

            }

            @Override
            public void surfaceDestroyed(SurfaceHolder holder) {

            }
        });

        barcodeDetector.setProcessor(new Detector.Processor<Barcode>() {
            @Override
            public void release() {

            }

            @Override
            public void receiveDetections(Detector.Detections<Barcode> detections) {
                final SparseArray<Barcode> qrcodes = detections.getDetectedItems();
                if(qrcodes.size() != 0) {
                    barcodeDetector.release();
                    textResult.post(new Runnable() {
                        @Override
                        public void run() {
                            Vibrator vibrator = (Vibrator) getApplicationContext().getSystemService(Context.VIBRATOR_SERVICE);
                            vibrator.vibrate(100);

                            textResult.setText(qrcodes.valueAt(0).displayValue);
                            code = qrcodes.valueAt(0).displayValue;
                            //////////
                            Call<ResponseBody> call = RetrofitClient.getInstance().getApi().userQR(studentId, instructorId, classId, code, assignedId, courseId);
                            call.enqueue(new Callback<ResponseBody>() {
                                @Override
                                public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
                                    try {
                                        String s = response.body().string();
                                        try {
                                            JSONObject jsonObject = new JSONObject(s);
                                            String status = jsonObject.getString("status");
                                            String msg = jsonObject.getString("message");
                                            String data = jsonObject.getString("data");

                                            if(status.equals("true")) {

                                                JSONObject jsonObject1 = new JSONObject(data);
                                                String attendance_id = jsonObject1.getString("att_id");
                                                String student_id = jsonObject1.getString("st_id");
                                                String assigned_id = jsonObject1.getString("assign_id");
                                                String status1 = jsonObject1.getString("statuss");
                                                String email = jsonObject1.getString("student_email");
                                                Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
                                                Intent intent = new Intent(QrScanner.this, FaceRecognition.class);
                                                intent.putExtra("attendance_id", attendance_id);
                                                intent.putExtra("student_id", student_id);
                                                intent.putExtra("assigned_id",assigned_id);
                                                intent.putExtra("status",status1);
                                                intent.putExtra("student_email",email);
                                                intent.putExtra("student_name", sname);
                                                startActivity(intent);

//                                                Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
                                            } else if(status.equals("false")) {
                                                Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();
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
                                    Toast.makeText(getApplicationContext(),t.getMessage(),Toast.LENGTH_LONG).show();
                                }
                            });

                        }
                    });
                }
            }
        });


    }
}
