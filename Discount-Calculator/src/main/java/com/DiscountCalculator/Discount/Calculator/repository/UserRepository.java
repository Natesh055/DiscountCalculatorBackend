package com.DiscountCalculator.Discount.Calculator.repository;

import com.DiscountCalculator.Discount.Calculator.entity.User;
import org.springframework.data.mongodb.repository.MongoRepository;

public interface UserRepository extends MongoRepository<User,String> {
    User findByEmail(String email);
}
