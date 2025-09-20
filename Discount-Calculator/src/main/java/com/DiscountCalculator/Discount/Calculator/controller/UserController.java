package com.DiscountCalculator.Discount.Calculator.controller;

import com.DiscountCalculator.Discount.Calculator.entity.User;
import com.DiscountCalculator.Discount.Calculator.service.UserService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/user")
@Slf4j
public class UserController {
    @Autowired
    UserService userService;

    @PostMapping
    public ResponseEntity<?>createUser(@RequestBody User user)
    {
        String email = user.getEmail();
        try {
            User isExistingUser = userService.findByEmail(email);
            if (isExistingUser == null) {
                //create the user
                userService.createUser(user);
                log.info("User created succesfully for user email "+ email );
                return new ResponseEntity<>("User created succesfully", HttpStatus.OK);
            }
            log.error("Duplicate email id found for the user with email "+ email );
            return new ResponseEntity<>(HttpStatus.CONFLICT);
        } catch (Exception e) {
            log.error("Unable to save the user in the database with email "+ email );
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
