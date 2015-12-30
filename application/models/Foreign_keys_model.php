<?php

class Foreign_keys_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}
	
	public function remove_all()
	{
		$this->db->trans_start();
		
		if($this->exists("admins_ibfk_1")) $this->db->query("ALTER TABLE `admins` DROP FOREIGN KEY `admins_ibfk_1`;");
		if($this->exists("course_block_positions_ibfk_1")) $this->db->query("ALTER TABLE `course_block_positions` DROP FOREIGN KEY `course_block_positions_ibfk_1`;");
		if($this->exists("course_block_positions_ibfk_2")) $this->db->query("ALTER TABLE `course_block_positions` DROP FOREIGN KEY `course_block_positions_ibfk_2`;");
		if($this->exists("course_material_ibfk_1")) $this->db->query("ALTER TABLE `course_material` DROP FOREIGN KEY `course_material_ibfk_1`;");
		if($this->exists("course_teachers_ibfk_1")) $this->db->query("ALTER TABLE `course_teachers` DROP FOREIGN KEY `course_teachers_ibfk_1`;");
		if($this->exists("course_teachers_ibfk_2")) $this->db->query("ALTER TABLE `course_teachers` DROP FOREIGN KEY `course_teachers_ibfk_2`;");
		if($this->exists("experience_events_ibfk_1")) $this->db->query("ALTER TABLE `experience_events` DROP FOREIGN KEY `experience_events_ibfk_1`;");
		if($this->exists("experience_events_ibfk_2")) $this->db->query("ALTER TABLE `experience_events` DROP FOREIGN KEY `experience_events_ibfk_2`;");
		if($this->exists("lessons_ibfk_1")) $this->db->query("ALTER TABLE `lessons` DROP FOREIGN KEY `lessons_ibfk_1`;");
		if($this->exists("payment_ibfk_1")) $this->db->query("ALTER TABLE `payment` DROP FOREIGN KEY `payment_ibfk_1`;");
		if($this->exists("payment_ibfk_2")) $this->db->query("ALTER TABLE `payment` DROP FOREIGN KEY `payment_ibfk_2`;");
		if($this->exists("profile_block_positions_ibfk_1")) $this->db->query("ALTER TABLE `profile_block_positions` DROP FOREIGN KEY `profile_block_positions_ibfk_1`;");
		if($this->exists("register_ibfk_1")) $this->db->query("ALTER TABLE `register` DROP FOREIGN KEY `register_ibfk_1`;");
		if($this->exists("register_ibfk_2")) $this->db->query("ALTER TABLE `register` DROP FOREIGN KEY `register_ibfk_2`;");
		if($this->exists("teachers_ibfk_1")) $this->db->query("ALTER TABLE `teachers` DROP FOREIGN KEY `teachers_ibfk_1`;");
		if($this->exists("user_achievements_rewards_ibfk_1")) $this->db->query("ALTER TABLE `user_achievements_rewards` DROP FOREIGN KEY `user_achievements_rewards_ibfk_1`;");
		if($this->exists("user_achievements_rewards_ibfk_2")) $this->db->query("ALTER TABLE `user_achievements_rewards` DROP FOREIGN KEY `user_achievements_rewards_ibfk_2`;");
		if($this->exists("user_achievements_rewards_ibfk_3")) $this->db->query("ALTER TABLE `user_achievements_rewards` DROP FOREIGN KEY `user_achievements_rewards_ibfk_3`;");
		if($this->exists("users_info_ibfk_1")) $this->db->query("ALTER TABLE `users_info` DROP FOREIGN KEY `users_info_ibfk_1`;");
		
		$this->db->trans_complete();
	}
	
	public function add_all()
	{
		$this->db->trans_start();
		
		$this->db->query("ALTER TABLE `admins` ADD FOREIGN KEY (`userID`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `course_block_positions` ADD FOREIGN KEY (`username`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `course_block_positions` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `course_material` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `course_teachers` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `course_teachers` ADD FOREIGN KEY (`teacherID`) REFERENCES `tflati_reseed`.`teachers`(`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `experience_events` ADD FOREIGN KEY (`username`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `experience_events` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `lessons` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `payment` ADD FOREIGN KEY (`userID`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `payment` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `profile_block_positions` ADD FOREIGN KEY (`username`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `register` ADD FOREIGN KEY (`userID`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `register` ADD FOREIGN KEY (`lessonID`) REFERENCES `tflati_reseed`.`lessons`(`lessonID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `teachers` ADD FOREIGN KEY (`teacherID`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `user_achievements_rewards` ADD FOREIGN KEY (`username`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `user_achievements_rewards` ADD FOREIGN KEY (`courseID`) REFERENCES `tflati_reseed`.`courses`(`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `user_achievements_rewards` ADD FOREIGN KEY (`achievementOrRewardID`) REFERENCES `tflati_reseed`.`achievements_and_rewards`(`achievementRewardID`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$this->db->query("ALTER TABLE `users_info` ADD FOREIGN KEY (`userID`) REFERENCES `tflati_reseed`.`users`(`Username`) ON DELETE CASCADE ON UPDATE CASCADE;");
		
		$this->db->trans_complete();
	}
	
	public function exists($id)
	{
		return $this->db->query("SELECT *
			FROM information_schema.REFERENTIAL_CONSTRAINTS
			WHERE CONSTRAINT_SCHEMA = 'tflati_reseed'
			AND CONSTRAINT_NAME = '".$id."'")->num_rows() == 1;
	}
}

?>