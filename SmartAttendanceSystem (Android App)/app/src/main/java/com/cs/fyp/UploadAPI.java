package com.cs.fyp;

import okhttp3.MultipartBody;
import retrofit2.Call;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;

public interface UploadAPI {
        @Multipart
        @POST("/")
        Call<Name> uploadImage(@Part MultipartBody.Part file);
    }

