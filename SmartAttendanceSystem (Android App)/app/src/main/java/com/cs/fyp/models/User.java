package com.cs.fyp.models;

public class User {

    private String id;
    private String email, name;

    public User() {

    }

    public User(String id, String email, String name) {
        this.id = id;
        this.email = email;
        this.name = name;
    }

    public String getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getEmail() {
        return email;
    }

    public void setId(String id) {
        this.id = id;
    }
}
