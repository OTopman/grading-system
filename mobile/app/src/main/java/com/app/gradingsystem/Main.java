package com.app.gradingsystem;

import android.app.DownloadManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageButton;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomsheet.BottomSheetDialog;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Main extends AppCompatActivity {

    FloatingActionButton student;
    ImageButton home,download;
    private BottomSheetDialog mBottomSheetDialog,bottomSheetDialog;

    SharedPreferences sharedPreferences;
    public String student_id,response,matric;

    public Func func;
    DownloadManager manager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        home = findViewById(R.id.home);
        download = findViewById(R.id.download);

        func = new Func(this);

        sharedPreferences = getSharedPreferences("ALL_USER_INFO", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("all_user_info", null);


        try {

            JSONObject object = new JSONObject(response);
            JSONObject student_info = object.getJSONObject("student_info");

            student_id = student_info.getString("id");
            matric = student_info.getString("matric");

        }catch (JSONException e){
            e.printStackTrace();
        }

        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();

        home.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
            }
        });

        download.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                AlertDialog.Builder builder1 = new AlertDialog.Builder(Main.this);
                builder1.setMessage("Are you sure, you want to download your project defense grading?");
                builder1.setCancelable(true);

                builder1.setPositiveButton(
                        "Yes",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();

                                func.startDialog();

                                StringRequest request = new StringRequest(Request.Method.POST, Core.SITE_URL, new Response.Listener<String>() {
                                    @Override
                                    public void onResponse(String response) {

                                        func.dismissDialog();

                                        try {

                                            JSONObject object = new JSONObject(response);

                                            if (object.getString("error").equals("0")){
                                                func.vibrate();;
                                                func.error_toast(object.getString("msg"));
                                                return;
                                            }

                                            DownloadManager downloadmanager = (DownloadManager) getSystemService(Context.DOWNLOAD_SERVICE);
                                            Uri uri = Uri.parse(Core.URI+object.getString("file"));

                                            DownloadManager.Request request2 = new DownloadManager.Request(uri);
                                            request2.setTitle(matric);
                                            request2.setDescription("Downloading");
                                            request2.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
                                            request2.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS,"defense");
                                            downloadmanager.enqueue(request2);

                                            Intent browserIntent = new Intent(Intent.ACTION_VIEW, Uri.parse(Core.URI+object.getString("file")));
                                            startActivity(browserIntent);

                                            func.success_toast("Your project defense grading has been downloaded successful");

                                        }catch (JSONException e){
                                            e.printStackTrace();
                                        }

                                    }
                                }, new Response.ErrorListener() {
                                    @Override
                                    public void onErrorResponse(VolleyError error) {
                                        func.vibrate();
                                        func.error_toast(error.toString());
                                        func.dismissDialog();
                                    }
                                }){
                                    @Override
                                    protected Map<String, String> getParams() throws AuthFailureError {
                                        Map<String, String> param = new HashMap<>();
                                        param.put("action", "download");
                                        param.put("student_id", student_id);
                                        return  param;
                                    }
                                };

                                RequestQueue queue = Volley.newRequestQueue(Main.this);
                                queue.add(request);

                            }
                        });

                builder1.setNegativeButton(
                        "No",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        });

                AlertDialog alert11 = builder1.create();
                alert11.show();

            }
        });

    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
    }


}
