package com.employeeperformance.system.repository;

import com.employeeperformance.system.entity.CreditHistory;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface CreditHistoryRepository extends JpaRepository<CreditHistory, Long> {

    List<CreditHistory> findByEmployeeIdOrderByAwardedAtDesc(Long employeeId);
}