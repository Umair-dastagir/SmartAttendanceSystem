package com.cs.fyp.api;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.POST;

public interface Api {

    @FormUrlEncoded
    @POST("sign_in")
    Call<ResponseBody> userLogin(
            @Field("email") String email,
            @Field("password") String password
    );

    @FormUrlEncoded
    @POST("mark_attendance")
    Call<ResponseBody> userQR(
            @Field("user_id") String user_id,
            @Field("instructor_id") String instructor_id,
            @Field("class_id") String class_id,
            @Field("qr_code") String qr_code,
            @Field("assigned_id") String assigned_id,
            @Field("course_id") String course_id
    );
    @FormUrlEncoded
    @POST("save_details")
    Call<ResponseBody> saveDetails(
            @Field("attendance_id") String attendance_id,
            @Field("student_id") String student_id,
            @Field("assigned_id") String assigned_id
    );
}