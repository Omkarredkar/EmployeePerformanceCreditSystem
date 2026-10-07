package com.employeeperformance.system.entity;

import jakarta.persistence.*;

@Entity
@Table(name = "employees")
public class Employee extends User {

    @Column(nullable = false)
    private String department;

    @Column(nullable = false)
    private String designation;

    @Column(nullable = false)
    private String skills;

    private double currentPerformance = 0.0;

    private int totalCredits = 0;

    public Employee() {
        super();
        setRole("EMPLOYEE");
    }

    public Employee(String username, String password, String fullName,
                    String email, String department,
                    String designation, String skills) {

        super(username, password, fullName, email, "EMPLOYEE");
        this.department = department;
        this.designation = designation;
        this.skills = skills;
    }

    public String getDepartment() {
        return department;
    }

    public String getDesignation() {
        return designation;
    }

    public String getSkills() {
        return skills;
    }

    public double getCurrentPerformance() {
        return currentPerformance;
    }

    public int getTotalCredits() {
        return totalCredits;
    }

    public void setDepartment(String department) {
        this.department = department;
    }

    public void setDesignation(String designation) {
        this.designation = designation;
    }

    public void setSkills(String skills) {
        this.skills = skills;
    }

    public void setCurrentPerformance(double currentPerformance) {
        this.currentPerformance = currentPerformance;
    }

    public void setTotalCredits(int totalCredits) {
        this.totalCredits = totalCredits;
    }
}