package com.DiscountCalculator.Discount.Calculator.service;

import com.DiscountCalculator.Discount.Calculator.entity.User;
import com.DiscountCalculator.Discount.Calculator.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class UserService {
    @Autowired
    UserRepository userRepository;

    public User findByEmail(String email)
    {
        return userRepository.findByEmail(email);
    }

    public User createUser(User user)
    {
        return userRepository.save(user);
    }
}
