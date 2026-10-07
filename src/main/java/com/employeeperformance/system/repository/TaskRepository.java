package com.employeeperformance.system.repository;

import com.employeeperformance.system.entity.Task;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface TaskRepository extends JpaRepository<Task, Long> {

    List<Task> findByEmployeeId(Long employeeId);

    List<Task> findByEmployeeIdAndCompleted(Long employeeId, boolean completed);

    long countByEmployeeId(Long employeeId);

    long countByEmployeeIdAndCompleted(Long employeeId, boolean completed);
}