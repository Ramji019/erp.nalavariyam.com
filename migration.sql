ALTER TABLE `users` CHANGE `group_id` `user_type_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `date` `created_at` DATE NULL;
ALTER TABLE `district` CHANGE `districtid` `districtid` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `upi` `upi` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `payment_qr_oode` `payment_qr_oode` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `user_type` CHANGE `user_discount` `user_discount` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `user_type` CHANGE `user_payment` `user_discount` VARCHAR(10);
ALTER TABLE `user_type` CHANGE `user_percentage` `user_discount` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

--18/06/2023
alter table users add wallet decimal(10,2) DEFAULT 0;
rename table notipikesan to notification;
alter table payments modify family_user_id varchar(10) DEFAULT NULL;
alter table payments modify adsional_amount varchar(10) DEFAULT NULL;
alter table payments modify reference_id varchar(20) DEFAULT NULL;

--19/06/2022
ALTER TABLE user_type add other_discount VARCHAR(10) DEFAULT null after user_discount;
update user_type set other_discount = user_discount/2 where user_discount is not null;
