package com.cs.fyp;

import android.content.Intent;
import android.os.Bundle;
import android.os.SystemClock;
import android.widget.ImageView;

import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {

    private ImageView img;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //createAccount("nasimkhankhilji39774@gmail.com", "123456789");
        SystemClock.sleep(3000);
        Intent newint = new Intent(MainActivity.this, LogIn.class);
        startActivity(newint);
        finish();
    }

}
