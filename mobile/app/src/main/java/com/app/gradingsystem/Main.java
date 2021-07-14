package com.app.gradingsystem;

import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageButton;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.bottomsheet.BottomSheetDialog;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class Main extends AppCompatActivity {

    FloatingActionButton student;
    ImageButton home,notification;
    private BottomSheetDialog mBottomSheetDialog,bottomSheetDialog;

    SharedPreferences sharedPreferences;
    public String response;

    public List<Lists> mData = new ArrayList<>();
    public RecyclerView recyclerView;
    public ListAdapters listAdapters;

    public Func func;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        sharedPreferences = getSharedPreferences("ALL_USER_INFO", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("all_user_info", null);

        student = findViewById(R.id.student);
        home = findViewById(R.id.home);
        notification = findViewById(R.id.notification);

        func = new Func(this);

        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();

        student.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                bottomSheet();
            }
        });

        home.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
            }
        });

       /* notification.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getSupportFragmentManager().beginTransaction().replace(R.id.container, new Notifications()).addToBackStack(null).commit();
            }
        });*/
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
    }



    public void bottomSheet(){

        final View view = getLayoutInflater().inflate(R.layout.bottomsheet, null);

        (view.findViewById(R.id.bt_close)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mBottomSheetDialog.dismiss();
            }
        });

        recyclerView = (RecyclerView) view.findViewById(R.id.my_recycler_view);
        listAdapters = new ListAdapters(mData);
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(this);
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setAdapter(listAdapters);

        mData = new ArrayList<>();


        try {

            JSONObject object = new JSONObject(response);
            JSONArray data = object.getJSONArray("hostel_data");

            for (int i = 0; i < data.length(); i++){
                JSONObject hostel_data = data.getJSONObject(i);
                mData.add(new Lists(hostel_data.getString("name"),hostel_data.getString("type"),"",hostel_data.getString("id"),"make_payment"));
            }


        }catch (JSONException e){
            e.printStackTrace();
        }

        mBottomSheetDialog = new BottomSheetDialog(this);
        mBottomSheetDialog.setContentView(view);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            mBottomSheetDialog.getWindow().addFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        }

        mBottomSheetDialog.show();
        mBottomSheetDialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialog) {
                mBottomSheetDialog = null;
            }
        });

    }
}
