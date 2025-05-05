
CREATE TABLE `communications_types` (
  `communication_type_id` bigint(20) NOT NULL,
  `communication_type_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `extra_fields` (
  `extra_fields_id` bigint(20) NOT NULL,
  `extra_fields_title` varchar(255) NOT NULL,
  `extra_fields_value` varchar(255) NOT NULL,
  `extra_fields_type` enum('number','text','email','tel','datetime-local','date','time','color','search','button') NOT NULL,
  `extra_fields_target` varchar(255) NOT NULL DEFAULT 'users',
  `extra_fields_status` enum('required','unique','unique_required','hidden','normal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `files` (
  `file_id` bigint(20) NOT NULL,
  `file_upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `file_original_name` varchar(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `permissions` (
  `permission_id` bigint(20) NOT NULL,
  `permission_link` varchar(255) NOT NULL,
  `permission_title` varchar(255) NOT NULL,
  `permission_author` varchar(255) NOT NULL,
  `permission_copyright` varchar(255) NOT NULL,
  `permission_description` varchar(255) NOT NULL,
  `permission_keywords` varchar(255) NOT NULL,
  `permission_image` varchar(255) NOT NULL,
  `permission_mother` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_reg_date` varchar(255) NOT NULL,
  `user_type_id` bigint(20) NOT NULL,
  `user_active_code` varchar(255) NOT NULL,
  `user_status` enum('new','activated','banned','expired','deleted') NOT NULL,
  `user_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users_types` (
  `user_type_id` bigint(20) NOT NULL,
  `user_type_title` varchar(255) NOT NULL,
  `user_type_permissions` text NOT NULL,
  `user_type_color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_communication` (
  `user_communication_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `communication_type_id` bigint(20) NOT NULL,
  `user_communication_value` varchar(255) NOT NULL,
  `user_communication_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `user_file` (
  `user_file_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `file_id` bigint(20) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_start_date` datetime NOT NULL,
  `file_end_date` datetime NOT NULL,
  `file_status` varchar(255) NOT NULL,
  `file_notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_permission` (
  `user_permission_id` bigint(20) NOT NULL,
  `permission_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `communications_types`
  ADD PRIMARY KEY (`communication_type_id`);

ALTER TABLE `extra_fields`
  ADD PRIMARY KEY (`extra_fields_id`);

ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `child` (`permission_mother`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `Member of` (`user_type_id`);

ALTER TABLE `users_types`
  ADD PRIMARY KEY (`user_type_id`);

ALTER TABLE `user_communication`
  ADD PRIMARY KEY (`user_communication_id`),
  ADD KEY `owns it` (`user_id`),
  ADD KEY `customize type` (`communication_type_id`);

ALTER TABLE `user_file`
  ADD PRIMARY KEY (`user_file_id`),
  ADD KEY `owner` (`user_id`),
  ADD KEY `property` (`file_id`);


ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`user_permission_id`),
  ADD KEY `user` (`user_id`);


ALTER TABLE `communications_types`
  MODIFY `communication_type_id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `extra_fields`
  MODIFY `extra_fields_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `files`
  MODIFY `file_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `permissions`
  MODIFY `permission_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `users_types`
  MODIFY `user_type_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `user_communication`
  MODIFY `user_communication_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `user_file`
  MODIFY `user_file_id` bigint(20) NOT NULL AUTO_INCREMENT;




ALTER TABLE `user_permission`
  MODIFY `user_permission_id` bigint(20) NOT NULL AUTO_INCREMENT;








ALTER TABLE `permissions`
  ADD CONSTRAINT `child` FOREIGN KEY (`permission_mother`) REFERENCES `permissions` (`permission_id`);




ALTER TABLE `users`
  ADD CONSTRAINT `Member of` FOREIGN KEY (`user_type_id`) REFERENCES `users_types` (`user_type_id`);




ALTER TABLE `user_communication`
  ADD CONSTRAINT `customize type` FOREIGN KEY (`communication_type_id`) REFERENCES `communications_types` (`communication_type_id`),
  ADD CONSTRAINT `owns it` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);




ALTER TABLE `user_file`
  ADD CONSTRAINT `owner` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `property` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`);




ALTER TABLE `user_permission`
  ADD CONSTRAINT `permission` FOREIGN KEY (`user_id`) REFERENCES `permissions` (`permission_id`),
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

