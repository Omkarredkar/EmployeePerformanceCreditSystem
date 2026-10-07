package com.employeeperformance.system.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "managers")
public class Manager extends User {

    @Column(nullable = false)
    private String department;

    public Manager() {
        super();
        setRole("MANAGER");
    }

    public Manager(String username, String password,
                   String fullName, String email,
                   String department) {

        super(username, password, fullName, email, "MANAGER");
        this.department = department;
    }

    public String getDepartment() {
        return department;
    }

    public void setDepartment(String department) {
        this.department = department;
    }
}