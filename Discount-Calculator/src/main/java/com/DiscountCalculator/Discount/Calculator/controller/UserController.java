package com.DiscountCalculator.Discount.Calculator.controller;

import com.DiscountCalculator.Discount.Calculator.entity.User;
import com.DiscountCalculator.Discount.Calculator.service.UserService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/user")
@Slf4j
public class UserController {
    @Autowired
    UserService userService;

    @GetMapping
    public ResponseEntity<?> getAllUsers()
    {
        try {
            List<User> allUsers =  userService.getAllUsers();
            if(allUsers == null || allUsers.isEmpty())
            {
                log.error("Unable to find users in the database" );
                return new ResponseEntity<>(HttpStatus.NO_CONTENT);
            }
            log.info("Entries found for users");
            return new ResponseEntity<>(allUsers,HttpStatus.OK);
        } catch (Exception e) {
            log.error("Unable to establish connection with database");
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

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

//    @DeleteMapping("/email/{userEmail}")
//    public ResponseEntity<?> deletUserByUserName(@PathVariable String userEmail)
//    {
//        User userToDelete = userService.findByEmail(userEmail);
//        try{
//            if(userToDelete==null)
//            {
//                log.error("Unable to find users in the database" );
//                return new ResponseEntity<>(HttpStatus.NO_CONTENT);
//            }
//            userService.deleteUserByEmail(userEmail);
//            log.info("User deleted successfully with email id: "+userEmail);
//            return new ResponseEntity<>(HttpStatus.OK);
//        }
//        catch (Exception exception)
//        {
//            log.error("Unable to delete the user from the database with email "+ userEmail );
//            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
//        }
//    }
}
