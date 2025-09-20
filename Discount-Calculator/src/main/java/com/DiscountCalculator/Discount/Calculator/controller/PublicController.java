package com.DiscountCalculator.Discount.Calculator.controller;

import lombok.extern.slf4j.Slf4j;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/public")
@Slf4j
public class PublicController
{
    @GetMapping("/health-check")
    public ResponseEntity<?> healthChecker()
    {
        log.info("Health is runnning ok,");
        return new ResponseEntity<>("Health is OK",HttpStatus.OK);
    }
}
