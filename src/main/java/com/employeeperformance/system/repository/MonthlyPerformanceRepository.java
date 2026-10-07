package com.employeeperformance.system.repository;

import com.employeeperformance.system.entity.MonthlyPerformance;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface MonthlyPerformanceRepository
        extends JpaRepository<MonthlyPerformance, Long> {

    List<MonthlyPerformance> findByMonthOrderByRankPositionAsc(String month);

    List<MonthlyPerformance> findByEmployeeIdOrderByGeneratedAtDesc(Long employeeId);
}