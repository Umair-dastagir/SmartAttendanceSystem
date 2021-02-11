package com.cs.fyp;

import android.content.ContentUris;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.provider.DocumentsContract;
import android.provider.MediaStore;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.FileProvider;

import com.cs.fyp.api.RetrofitClient;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.concurrent.TimeUnit;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class FaceRecognition extends AppCompatActivity {

    private Button cameraButton;
    private Button choosePhoto;
    private static String selectedImagePath;

    private static final String BASE_URL = "https://e4a170fd4c3e.ngrok.io";
    private static Retrofit retrofit = null;
    private Uri capturedPhotoUri;
    String studentId, attendanceId, status, assigned_id, email, sname;
    private String[] REQUIRED_PERMISSIONS = new String[]{"android.permission.CAMERA", "android.permission.WRITE_EXTERNAL_STORAGE"};
    private Bitmap imageBitmap;
    static final int REQUEST_TAKE_PHOTO = 1;
    String currentPhotoPath;
    Uri contentUri;
    private static final String DEFAULT_PICTURE_NAME = "Example.jpg";

    @Override
    public void onBackPressed() {
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
     getMenuInflater().inflate(R.menu.menu_facrec,menu);
     return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()){
            case R.id.cancel:
                Intent i = new Intent(FaceRecognition.this, Courses.class);
                i.putExtra("student_id",studentId);
                i.putExtra("student_name", sname);
                startActivity(i);
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_face_recognition);



        if (savedInstanceState == null) {
            Bundle extras = getIntent().getExtras();
            if(extras == null) {
                studentId= null;
                attendanceId = null;
                status = null;
                assigned_id = null;
                sname = null;
            } else {
                studentId= extras.getString("student_id");
                attendanceId = extras.getString("attendance_id");
                status = extras.getString("status");
                assigned_id = extras.getString("assigned_id");
                email = extras.getString("student_email");
                sname = extras.getString("student_name");
            }
        } else {
            studentId= (String) savedInstanceState.getSerializable("student_id");
            attendanceId= (String) savedInstanceState.getSerializable("attendance_id");
            status= (String) savedInstanceState.getSerializable("status");
            assigned_id= (String) savedInstanceState.getSerializable("assigned_id");
            email = (String) savedInstanceState.getSerializable("student_email");
            sname = (String) savedInstanceState.getSerializable("student_name");
        }

        //Toast.makeText(getApplicationContext(), email, Toast.LENGTH_SHORT).show();
        capturedPhotoUri = getIntent().getData();
        if(capturedPhotoUri != null){
            selectedImagePath = getPath(getApplicationContext(), capturedPhotoUri);
////////////// Retrofit Call

            ByteArrayOutputStream stream = new ByteArrayOutputStream();
            BitmapFactory.Options options = new BitmapFactory.Options();
            options.inPreferredConfig = Bitmap.Config.RGB_565;
            // Read BitMap by file path
            Bitmap bitmap = BitmapFactory.decodeFile(selectedImagePath, options);
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, stream);
            byte[] byteArray = stream.toByteArray();

            RequestBody postBodyImage = new MultipartBody.Builder()
                    .setType(MultipartBody.FORM)
                    .addFormDataPart("image", "androidFlask.jpg", RequestBody.create(byteArray, MediaType.parse("image/*jpg")))
                    .build();

            TextView responseText = findViewById(R.id.responseText);
            responseText.setText("Please wait ...");

            //postRequest(postUrl, postBodyImage);
            uploadToServer(capturedPhotoUri);

//////////// Retrofit Call
            Toast.makeText(getApplicationContext(), selectedImagePath, Toast.LENGTH_LONG).show();
        }
        cameraButton = findViewById(R.id.btn_detect);
        cameraButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                if (intent.resolveActivity(getPackageManager()) != null) {
                    // Create the File where the photo should go
                    File photoFile = null;
                    try {
                        photoFile = createImageFile();
                    } catch (IOException ex) {
                        // Error occurred while creating the File
                    }
                    // Continue only if the File was successfully created
                    if (photoFile != null) {
                        Uri photoURI = FileProvider.getUriForFile(getApplicationContext(),"com.cs.fyp", photoFile);
                        intent.setFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION | Intent.FLAG_GRANT_WRITE_URI_PERMISSION);
                        intent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI);
                        startActivityForResult(intent, REQUEST_TAKE_PHOTO);
                    }
                }
            }
        });

        choosePhoto = findViewById(R.id.btn_choose);
        choosePhoto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.INTERNAL_CONTENT_URI);
                startActivityForResult(intent, 0);
            }
        });
    }

    private File createImageFile() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG_" + timeStamp + "_";
        File storageDir = getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(
                imageFileName,  /* prefix */
                ".jpg",         /* suffix */
                storageDir      /* directory */
        );

        // Save a file: path for use with ACTION_VIEW intents
        currentPhotoPath = image.getAbsolutePath();
        return image;
    }

    @Override
    protected void onActivityResult(int reqCode, int resCode, Intent data) {
        super.onActivityResult(reqCode, resCode, data);
        if (resCode == RESULT_OK && reqCode == 0 && data != null) {
            Uri uri = data.getData();

            Bitmap bitmap = null;

            try {
                bitmap = MediaStore.Images.Media.getBitmap(
                        this.getContentResolver(), uri);

            } catch (Exception e) {
                // Manage exception ...
            }

            if (bitmap != null) {
                // Here you can use bitmap in your application ...
                selectedImagePath = getPath(getApplicationContext(), uri);
////////////// Retrofit Call

                ByteArrayOutputStream stream = new ByteArrayOutputStream();
                BitmapFactory.Options options = new BitmapFactory.Options();
                options.inPreferredConfig = Bitmap.Config.RGB_565;
                // Read BitMap by file path
                //Bitmap bitmap = BitmapFactory.decodeFile(selectedImagePath, options);
                bitmap.compress(Bitmap.CompressFormat.JPEG, 100, stream);
                byte[] byteArray = stream.toByteArray();

                RequestBody postBodyImage = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("image", "androidFlask.jpg", RequestBody.create(byteArray, MediaType.parse("image/*jpg")))
                        .build();

                TextView responseText = findViewById(R.id.responseText);
                responseText.setText("Please wait while we try to verify you...");

                //postRequest(postUrl, postBodyImage);
                uploadToServer(uri);

//////////// Retrofit Call
                Toast.makeText(getApplicationContext(), selectedImagePath, Toast.LENGTH_LONG).show();
            }
        }

        else if(reqCode == REQUEST_TAKE_PHOTO && resCode == RESULT_OK){
            File f = new File(currentPhotoPath);
            contentUri = Uri.fromFile(f);

            Bitmap bitmap = null;
            try {
                BitmapFactory.Options bitmapOptions = new BitmapFactory.Options();
                bitmap = BitmapFactory.decodeFile(f.getAbsolutePath(),
                        bitmapOptions);

            } catch (Exception e) {
                // Manage exception ...
            }

            if(bitmap != null){

                ByteArrayOutputStream stream = new ByteArrayOutputStream();
                BitmapFactory.Options options = new BitmapFactory.Options();
                options.inPreferredConfig = Bitmap.Config.RGB_565;
                // Read BitMap by file path
                //Bitmap bitmap = BitmapFactory.decodeFile(selectedImagePath, options);
                bitmap.compress(Bitmap.CompressFormat.JPEG, 100, stream);
                byte[] byteArray = stream.toByteArray();

                RequestBody postBodyImage = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("image", "androidFlask.jpg", RequestBody.create(byteArray, MediaType.parse("image/*jpg")))
                        .build();

                TextView responseText = findViewById(R.id.responseText);
                responseText.setText("Please wait while we try to verify you...");

                //postRequest(postUrl, postBodyImage);
                uploadToServerCamera(contentUri);

                Toast.makeText(getBaseContext(),currentPhotoPath,Toast.LENGTH_LONG).show();
            }
            else{
                Toast.makeText(getBaseContext(),"Not Received",Toast.LENGTH_SHORT).show();
            }
        }
    }
    public static Retrofit getRetrofitClient(Context context) {
        if (retrofit == null) {
            OkHttpClient eagerClient = new OkHttpClient.Builder()
                    .build();
            OkHttpClient okHttpClient = eagerClient.newBuilder()
                    .readTimeout(87000, TimeUnit.MILLISECONDS)
                    .connectTimeout(87000, TimeUnit.MILLISECONDS)
                    .writeTimeout(87000, TimeUnit.MILLISECONDS)
                    .callTimeout(87000, TimeUnit.MILLISECONDS)
                    .build();
            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .client(okHttpClient)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return retrofit;
    }

    private void uploadToServer(Uri uri) {
        Bitmap bitmap = null;

        try {
            bitmap = MediaStore.Images.Media.getBitmap(
                    this.getContentResolver(), uri);

        } catch (Exception e) {
            // Manage exception ...
        }

        if (bitmap != null) {

            Retrofit retrofit = getRetrofitClient(this);
            UploadAPI uploadAPIs = retrofit.create(UploadAPI.class);
            //Create a file object using file path
            //File file = new File(filePath);

            ByteArrayOutputStream stream = new ByteArrayOutputStream();
            //BitmapFactory.Options options = new BitmapFactory.Options();
            //options.inPreferredConfig = Bitmap.Config.RGB_565;
            // Read BitMap by file path
            //Bitmap bitmap = BitmapFactory.decodeFile(selectedImagePath, options);
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, stream);
            byte[] byteArray = stream.toByteArray();


            RequestBody fileReqBody = RequestBody.create(byteArray, MediaType.parse("image/*jpg"));
            // Create MultipartBody.Part using file request-body,file name and part name
            MultipartBody.Part part = MultipartBody.Part.createFormData("image", "androidFlask.jpg", fileReqBody);
            //
            Call<Name> call = uploadAPIs.uploadImage(part);
            call.enqueue(new Callback<Name>() {
                TextView responseText = findViewById(R.id.responseText);

                @Override
                public void onResponse(Call<Name> call, Response<Name> response) {
                    if (!response.isSuccessful()) {
                        responseText.setText("Code " + response.code());
                        return;
                    } else {
                        String loggedOnEmail = email;
                        Name name =  response.body();
                        String recognizedEmail = name.getMatchedName();
                        if(loggedOnEmail.equals(recognizedEmail)) {
                            responseText.setText("Matched");
                            Call<ResponseBody> call1 = RetrofitClient.getInstance().getApi().saveDetails(attendanceId, studentId, assigned_id);
                            call1.enqueue(new Callback<ResponseBody>() {
                                @Override
                                public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
                                    try {
                                        String s = response.body().string();
                                        try {
                                            JSONObject jsonObject = new JSONObject(s);
                                            String status = jsonObject.getString("status");
                                            String msg = jsonObject.getString("message");
                                            String data = jsonObject.getString("data");

//                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();

                                            if(status.equals("true")) {
                                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();
                                                Intent intt = new Intent(FaceRecognition.this, Courses.class);
                                                intt.putExtra("student_id",studentId);
                                                intt.putExtra("student_name", sname);
                                                startActivity(intt);
                                                finish();
                                            }
                                            if(status.equals("false")) {
                                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();
                                            }

                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }


                                    } catch (IOException e) {
                                        e.printStackTrace();
                                    }

                                }

                                @Override
                                public void onFailure(Call<ResponseBody> call, Throwable throwable) {
                                    Toast.makeText(getApplicationContext(),throwable.getMessage(),Toast.LENGTH_LONG).show();
                                }
                            });
                            //finish();
                        }
                        else
                            responseText.setText("Not Verified");
                    }
                }

                @Override
                public void onFailure(Call<Name> call, Throwable t) {
                    if(t.getMessage() == "timeout")
                        responseText.setText("Please try again...");
                    else
                        responseText.setText(t.getMessage());
                }
            });
        }
    }

    private void uploadToServerCamera(Uri uri) {
        Bitmap bitmap = null;

        try {
            BitmapFactory.Options bitmapOptions = new BitmapFactory.Options();
            bitmap = BitmapFactory.decodeFile(currentPhotoPath,
                    bitmapOptions);

        } catch (Exception e) {
            // Manage exception ...
        }

        if (bitmap != null) {

            Retrofit retrofit = getRetrofitClient(this);
            UploadAPI uploadAPIs = retrofit.create(UploadAPI.class);
            //Create a file object using file path
            //File file = new File(filePath);

            ByteArrayOutputStream stream = new ByteArrayOutputStream();
            //BitmapFactory.Options options = new BitmapFactory.Options();
            //options.inPreferredConfig = Bitmap.Config.RGB_565;
            // Read BitMap by file path
            //Bitmap bitmap = BitmapFactory.decodeFile(selectedImagePath, options);
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, stream);
            byte[] byteArray = stream.toByteArray();


            RequestBody fileReqBody = RequestBody.create(byteArray, MediaType.parse("image/*jpg"));
            // Create MultipartBody.Part using file request-body,file name and part name
            MultipartBody.Part part = MultipartBody.Part.createFormData("image", "androidFlask.jpg", fileReqBody);
            //
            Call<Name> call = uploadAPIs.uploadImage(part);
            call.enqueue(new Callback<Name>() {
                TextView responseText = findViewById(R.id.responseText);

                @Override
                public void onResponse(Call<Name> call, Response<Name> response) {
                    if (!response.isSuccessful()) {
                        responseText.setText("Code " + response.code());
                        return;
                    } else {
                        String loggedOnEmail = email;
                        Name name =  response.body();
                        String recognizedEmail = name.getMatchedName();
                        if(loggedOnEmail.equals(recognizedEmail)) {
                            responseText.setText("Matched");
                            Call<ResponseBody> call1 = RetrofitClient.getInstance().getApi().saveDetails(attendanceId, studentId, assigned_id);
                            call1.enqueue(new Callback<ResponseBody>() {
                                @Override
                                public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
                                    try {
                                        String s = response.body().string();
                                        try {
                                            JSONObject jsonObject = new JSONObject(s);
                                            String status = jsonObject.getString("status");
                                            String msg = jsonObject.getString("message");
                                            String data = jsonObject.getString("data");

//                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();

                                            if(status.equals("true")) {
                                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();
                                                Intent intt = new Intent(FaceRecognition.this, Courses.class);
                                                intt.putExtra("student_id",studentId);
                                                intt.putExtra("student_name", sname);
                                                startActivity(intt);
                                                finish();
                                            }
                                            if(status.equals("false")) {
                                                Toast.makeText(getApplicationContext(),msg,Toast.LENGTH_LONG).show();
                                            }

                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }


                                    } catch (IOException e) {
                                        e.printStackTrace();
                                    }

                                }

                                @Override
                                public void onFailure(Call<ResponseBody> call, Throwable throwable) {
                                    Toast.makeText(getApplicationContext(),throwable.getMessage(),Toast.LENGTH_LONG).show();
                                }
                            });
                            //finish();
                        }
                        else
                            responseText.setText("Not Matched");
                    }
                }

                @Override
                public void onFailure(Call<Name> call, Throwable t) {
                    if(t.getMessage() == "timeout")
                        responseText.setText("Please try again...");
                    else
                        responseText.setText(t.getMessage());
                }
            });
        }
    }
    /**
     * Get a file path from a Uri. This will get the the path for Storage Access
     * Framework Documents, as well as the _data field for the MediaStore and
     * other file-based ContentProviders.
     *
     * @param context The context.
     * @param uri     The Uri to query.
     * @author paulburke
     */
    public static String getPath(final Context context, final Uri uri) {

        final boolean isKitKat = Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT;

        // DocumentProvider
        if (isKitKat && DocumentsContract.isDocumentUri(context, uri)) {
            // ExternalStorageProvider
            if (isExternalStorageDocument(uri)) {
                final String docId = DocumentsContract.getDocumentId(uri);
                final String[] split = docId.split(":");
                final String type = split[0];

                if ("primary".equalsIgnoreCase(type)) {
                    return Environment.getExternalStorageDirectory() + "/" + split[1];
                }

                // TODO handle non-primary volumes
            }
            // DownloadsProvider
            else if (isDownloadsDocument(uri)) {

                final String id = DocumentsContract.getDocumentId(uri);
                final Uri contentUri = ContentUris.withAppendedId(
                        Uri.parse("content://downloads/public_downloads"), Long.valueOf(id));

                return getDataColumn(context, contentUri, null, null);
            }
            // MediaProvider
            else if (isMediaDocument(uri)) {
                final String docId = DocumentsContract.getDocumentId(uri);
                final String[] split = docId.split(":");
                final String type = split[0];

                Uri contentUri = null;
                if ("image".equals(type)) {
                    contentUri = MediaStore.Images.Media.EXTERNAL_CONTENT_URI;
                } else if ("video".equals(type)) {
                    contentUri = MediaStore.Video.Media.EXTERNAL_CONTENT_URI;
                } else if ("audio".equals(type)) {
                    contentUri = MediaStore.Audio.Media.EXTERNAL_CONTENT_URI;
                }

                final String selection = "_id=?";
                final String[] selectionArgs = new String[]{
                        split[1]
                };

                return getDataColumn(context, contentUri, selection, selectionArgs);
            }
        }
        // MediaStore (and general)
        else if ("content".equalsIgnoreCase(uri.getScheme())) {
            return getDataColumn(context, uri, null, null);
        }
        // File
        else if ("file".equalsIgnoreCase(uri.getScheme())) {
            return uri.getPath();
        }

        return null;
    }

    /**
     * Get the value of the data column for this Uri. This is useful for
     * MediaStore Uris, and other file-based ContentProviders.
     *
     * @param context       The context.
     * @param uri           The Uri to query.
     * @param selection     (Optional) Filter used in the query.
     * @param selectionArgs (Optional) Selection arguments used in the query.
     * @return The value of the _data column, which is typically a file path.
     */
    public static String getDataColumn(Context context, Uri uri, String selection,
                                       String[] selectionArgs) {

        Cursor cursor = null;
        final String column = "_data";
        final String[] projection = {
                column
        };

        try {
            cursor = context.getContentResolver().query(uri, projection, selection, selectionArgs,
                    null);
            if (cursor != null && cursor.moveToFirst()) {
                final int column_index = cursor.getColumnIndexOrThrow(column);
                return cursor.getString(column_index);
            }
        } finally {
            if (cursor != null)
                cursor.close();
        }
        return null;
    }


    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is ExternalStorageProvider.
     */
    public static boolean isExternalStorageDocument(Uri uri) {
        return "com.android.externalstorage.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is DownloadsProvider.
     */
    public static boolean isDownloadsDocument(Uri uri) {
        return "com.android.providers.downloads.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is MediaProvider.
     */
    public static boolean isMediaDocument(Uri uri) {
        return "com.android.providers.media.documents".equals(uri.getAuthority());
    }
}

