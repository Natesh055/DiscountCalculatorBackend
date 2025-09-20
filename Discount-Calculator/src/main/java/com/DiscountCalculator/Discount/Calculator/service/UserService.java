package com.DiscountCalculator.Discount.Calculator.service;

import com.DiscountCalculator.Discount.Calculator.entity.User;
import com.DiscountCalculator.Discount.Calculator.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class UserService {
    @Autowired
    UserRepository userRepository;

    public User findByEmail(String email)
    {
        return userRepository.findByEmail(email);
    }

    public void createUser(User user)
    {
        userRepository.save(user);
    }
    public List<User> getAllUsers()
    {
        return userRepository.findAll();
    }
    public void deleteUserByEmail(String email)
    {
        userRepository.deleteById(email);
    }
}
