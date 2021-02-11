package com.cs.fyp;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class CourseAdapter extends RecyclerView.Adapter<CourseAdapter.ViewHolder> {
    List<CourseItems> listItems;
    Context context;

    public CourseAdapter(List<CourseItems> listItems, Context context) {
        this.listItems = listItems;
        this.context = context;
    }


    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        View v = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.course_items, viewGroup, false);
        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(@NonNull CourseAdapter.ViewHolder viewHolder, int i) {
        CourseItems courseItem = listItems.get(i);

        String Cname = courseItem.getText1();

        viewHolder.textView.setText(courseItem.getText1());
        viewHolder.textView2.setText(courseItem.getText2());
        viewHolder.textView3.setText(courseItem.getText3());
        viewHolder.textView4.setText(courseItem.getText4());
        viewHolder.textView5.setText(courseItem.getText5());
        viewHolder.textView6.setText(courseItem.getText6());
        viewHolder.textView7.setText(courseItem.getText7());
        viewHolder.textView8.setText(courseItem.getText8());
        viewHolder.textView9.setText(courseItem.getText9());
        viewHolder.textView10.setText(courseItem.getText10());
        viewHolder.textView11.setText(courseItem.getText11());
        viewHolder.textView12.setText(courseItem.getText12());

        viewHolder.textView2.setVisibility(View.INVISIBLE);
        viewHolder.textView3.setVisibility(View.INVISIBLE);
        viewHolder.textView4.setVisibility(View.INVISIBLE);
        viewHolder.textView5.setVisibility(View.INVISIBLE);
        viewHolder.textView6.setVisibility(View.INVISIBLE);
        viewHolder.textView7.setVisibility(View.INVISIBLE);
        viewHolder.textView8.setVisibility(View.INVISIBLE);
        viewHolder.textView9.setVisibility(View.INVISIBLE);
        viewHolder.textView11.setVisibility(View.INVISIBLE);
        viewHolder.textView12.setVisibility(View.INVISIBLE);

    }

    @Override
    public int getItemCount() {
        return listItems.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        public TextView textView;
        public TextView textView2;
        public TextView textView3;
        public TextView textView4;
        public TextView textView5;
        public TextView textView6;
        public TextView textView7;
        public TextView textView8;
        public TextView textView9;
        public TextView textView10;
        public TextView textView11;
        public TextView textView12;
        public Button btnmark;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);

            textView = itemView.findViewById(R.id.textView);
            textView2 = itemView.findViewById(R.id.textView2);
            textView3 = itemView.findViewById(R.id.textView3);
            textView4 = itemView.findViewById(R.id.ins_id);
            textView5 = itemView.findViewById(R.id.class_id);
            textView6 = itemView.findViewById(R.id.assigned_id);
            textView7 = itemView.findViewById(R.id.type);
            textView8 = itemView.findViewById(R.id.total);
            textView9 = itemView.findViewById(R.id.attend);
            textView10 = itemView.findViewById(R.id.percent);
            textView11 = itemView.findViewById(R.id.course_id);
            textView12 = itemView.findViewById(R.id.sname);
            btnmark = itemView.findViewById(R.id.buttonMark);

            btnmark.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Toast.makeText(view.getContext(), textView.getText(), Toast.LENGTH_LONG).show();
                    Intent intent = new Intent(view.getContext(), QrScanner.class);
                    intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    intent.putExtra("student_id", textView3.getText());
                    intent.putExtra("ins_id",textView4.getText());
                    intent.putExtra("class_id",textView5.getText());
                    intent.putExtra("assigned_id", textView6.getText());
                    intent.putExtra("course_id", textView11.getText());
                    intent.putExtra("student_name", textView12.getText());
                    context.startActivity(intent);
                }
            });

            /*itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
//                  Toast.makeText(v.getContext(), textView.getText(), Toast.LENGTH_LONG).show();
                    Intent intent = new Intent(v.getContext(), QrScanner.class);
                    intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    intent.putExtra("student_id", textView3.getText());
                    intent.putExtra("ins_id",textView4.getText());
                    intent.putExtra("class_id",textView5.getText());
                    intent.putExtra("assigned_id", textView6.getText());
                    intent.putExtra("course_id", textView11.getText());
                    context.startActivity(intent);
                }
            });*/
        }
    }
}
