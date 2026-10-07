package com.employeeperformance.system.entity;

import jakarta.persistence.*;

import java.time.LocalDateTime;

@Entity
@Table(name = "monthly_performance")
public class MonthlyPerformance {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne
    @JoinColumn(name = "employee_id", nullable = false)
    private Employee employee;

    @Column(nullable = false)
    private String month;

    @Column(nullable = false)
    private double performanceScore;

    @Column(nullable = false)
    private int rankPosition;

    private String recommendation;

    private boolean approved = false;

    private LocalDateTime generatedAt = LocalDateTime.now();

    public MonthlyPerformance() {
    }

    public Long getId() {
        return id;
    }

    public Employee getEmployee() {
        return employee;
    }

    public String getMonth() {
        return month;
    }

    public double getPerformanceScore() {
        return performanceScore;
    }

    public int getRankPosition() {
        return rankPosition;
    }

    public String getRecommendation() {
        return recommendation;
    }

    public boolean isApproved() {
        return approved;
    }

    public LocalDateTime getGeneratedAt() {
        return generatedAt;
    }

    public void setEmployee(Employee employee) {
        this.employee = employee;
    }

    public void setMonth(String month) {
        this.month = month;
    }

    public void setPerformanceScore(double performanceScore) {
        this.performanceScore = performanceScore;
    }

    public void setRankPosition(int rankPosition) {
        this.rankPosition = rankPosition;
    }

    public void setRecommendation(String recommendation) {
        this.recommendation = recommendation;
    }

    public void setApproved(boolean approved) {
        this.approved = approved;
    }
}