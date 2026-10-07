package com.employeeperformance.system.entity;

import jakarta.persistence.*;

import java.time.LocalDateTime;

@Entity
@Table(name = "credit_history")
public class CreditHistory {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne
    @JoinColumn(name = "employee_id", nullable = false)
    private Employee employee;

    @Column(nullable = false)
    private int creditsAwarded;

    @Column(nullable = false)
    private double performanceScore;

    @Column(nullable = false)
    private LocalDateTime awardedAt = LocalDateTime.now();

    private String reason;

    public CreditHistory() {
    }

    public Long getId() {
        return id;
    }

    public Employee getEmployee() {
        return employee;
    }

    public int getCreditsAwarded() {
        return creditsAwarded;
    }

    public double getPerformanceScore() {
        return performanceScore;
    }

    public LocalDateTime getAwardedAt() {
        return awardedAt;
    }

    public String getReason() {
        return reason;
    }

    public void setEmployee(Employee employee) {
        this.employee = employee;
    }

    public void setCreditsAwarded(int creditsAwarded) {
        this.creditsAwarded = creditsAwarded;
    }

    public void setPerformanceScore(double performanceScore) {
        this.performanceScore = performanceScore;
    }

    public void setReason(String reason) {
        this.reason = reason;
    }
}