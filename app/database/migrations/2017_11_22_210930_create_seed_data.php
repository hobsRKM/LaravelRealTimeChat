<?php

use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Database\Migrations\Migration; 

class CreateSeedData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::insert("INSERT INTO `team_channels` (`id`, `channel_name_id`, `team_channel_id`, `author_id`, `channel_view_name`, `created_at`) VALUES
(4, 2, ?, 7, 'Engineering Team', '2017-11-25 16:53:17')", ['$2y$10$YGn8s58AHb7z9tWJNvY5Pe9LED90UPgL7Y56bNDTOLmg8DruNJDM2']); 




		DB::insert("INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `contact`, `created_at`, `updated_at`, `remember_token`, `profile_pic`, `gender`, `birthday`, `summary`) VALUES(7, 'admin', 'user', ?, 'demo@demo.com', NULL, '2017-11-25 16:52:37', '2017-11-26 04:36:32', 'q5kXdKcXAADIkCupBiSau5ClhAmu4HCxOmOpnpegIunoVrOMoO78tBnU7rej', NULL, '', '', '');
		", ['$2y$10$buh3p6IzXqfxopLc2tRyk.FTuwhWxNfBNz.fT0VI14JTEBMlGyY1.']); 
DB::insert("INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `contact`, `created_at`, `updated_at`, `remember_token`, `profile_pic`, `gender`, `birthday`, `summary`) VALUES(8, 'user1', '', ?, 'user1@gmail.com', NULL, '2017-11-26 04:37:55', '2017-11-26 04:37:55', NULL, NULL, '', '', '');
", ['$2y$10$s9jZqpBEb/nbVMHp1f2xN.Y7XoPPaHDkxCdTYHl2DPjiufOWwZ/8i']); 

		DB::select(DB::raw("INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(7, 7, 1),
(8, 8, 3)")); 

		DB::select(DB::raw("INSERT INTO `tracker_status_names` (`id`, `un_id`, `name`, `created_at`) VALUES
(1, '145536769056bf260acc567', 'New', '2016-01-25 00:39:54'),
(2, '145536772256bf262a1bff2', 'In Progress', '2016-01-25 00:39:54'),
(3, '145536772256bf262a1c070', 'Resolved', '2016-01-25 00:39:54'),
(4, '145536772256bf262a1c0bc', 'Due', '2016-01-25 00:39:54'),
(5, '145536772256bf262a1c110', 'Closed', '2016-01-25 00:39:54'),
(6, '145536772256bf262afgh1c110', 'Critical', '2016-02-20 12:09:30')")); 

		DB::select(DB::raw("INSERT INTO `tracker_priority` (`id`, `un_id`, `name`, `created_at`) VALUES
(1, '145536762856bf25cc5b39b', 'Low', '2016-01-25 00:46:17'),
(2, '145536762856bf25cc5b39c', 'Normal', '2016-01-25 00:46:17'),
(3, '145536762856bf25cc5b39d', 'High', '2016-01-25 00:46:17'),
(4, '145536762856bf25cc5b39e', 'Urgent', '2016-01-25 00:46:17'),
(5, '145536762856bf25cc5b39f', 'Immideate', '2016-01-25 00:46:17')")); 

		DB::select(DB::raw("INSERT INTO `tracker_description` (`id`, `un_id`, `tracker_activity_un_id`, `description`, `created_at`, `updated_at`) VALUES
(8, '2abaa23e3852d2a4402ab2d66dd95c73', '2abaa23e3852d2a4402ab2d66dd95c73', 'Start with the Design and Implementation of content Delivery', '2017-11-26 04:40:50', '2017-11-26 04:40:50'),
(9, 'b5183d5bf91331e89a0f72027a4ec565', 'b5183d5bf91331e89a0f72027a4ec565', 'Start with the Design and Implementation of content Delivery', '2017-11-26 04:41:26', '2017-11-26 04:41:26')
")); 

		DB::select(DB::raw("INSERT INTO `tracker` (`id`, `un_id`, `name`, `created_at`) VALUES
(1, '145536751356bf255949ed0', 'Task', '2016-01-25 00:33:18'),
(2, '145536757556bf2597c85de', 'Feature', '2016-01-25 00:33:18'),
(3, '145536758656bf25a22a8bc', 'Backlog', '2016-01-25 00:33:18'),
(4, '145536759956bf25af5f835', 'Bug', '2016-01-25 00:33:18')")); 

		//
		DB::select(DB::raw("INSERT INTO `team_heads` (`id`, `project_id`, `team_id`, `author_id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 'f61af4a69c3592044a736ed6d9472243', 4, 7, 7, '2017-11-25 16:53:17', '2017-11-25 16:53:17')")); 

		DB::select(DB::raw("INSERT INTO `team_channel_users` (`id`, `team_channel_name_id`, `user_id`) VALUES
(28, 4, 7),
(29, 4, 8)")); 

		DB::select(DB::raw("INSERT INTO `task_updated_activities` (`id`, `un_id`, `parent_tracker_activity_un_id`, `tracker_activity_un_id`, `by_user_id`, `to_user_id`, `created_at`) VALUES
(8, '2abaa23e3852d2a4402ab2d66dd95c73', '2abaa23e3852d2a4402ab2d66dd95c73', '2abaa23e3852d2a4402ab2d66dd95c73', NULL, NULL, '2017-11-26 04:40:50'),
(9, 'b5183d5bf91331e89a0f72027a4ec565', 'b5183d5bf91331e89a0f72027a4ec565', 'b5183d5bf91331e89a0f72027a4ec565', NULL, NULL, '2017-11-26 04:41:26')
")); 
		//
		DB::select(DB::raw("INSERT INTO `task_activities` (`id`, `un_id`, `tracker_id`, `tracker_status_id`, `tracker_priority_id`, `tracker_subject`, `project_id`, `team_id`, `user_id`, `created_at`, `updated_at`, `start_date`, `end_date`) VALUES
(8, '2abaa23e3852d2a4402ab2d66dd95c73', '145536751356bf255949ed0', '145536769056bf260acc567', '145536762856bf25cc5b39c', 'Content Delivery Design', 'f61af4a69c3592044a736ed6d9472243', 4, 8, '2017-11-26 04:40:50', '2017-11-26 04:40:50', '2017-11-25 18:30:00', '2017-11-29 18:30:00'),
(9, 'b5183d5bf91331e89a0f72027a4ec565', '145536751356bf255949ed0', '145536769056bf260acc567', '145536762856bf25cc5b39c', 'Content Delivery Technology', 'f61af4a69c3592044a736ed6d9472243', 4, 7, '2017-11-26 04:41:26', '2017-11-26 04:41:26', '2017-11-25 18:30:00', '2017-11-28 18:30:00')")); 

		DB::select(DB::raw("INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'IT-Admin'),
(2, 'Lecturer'),
(3, 'IT-Employee'),
(4, 'Student')")); 

		DB::select(DB::raw("INSERT INTO `projects` (`id`, `un_id`, `project_name`, `created_at`) VALUES
(8, 'f61af4a69c3592044a736ed6d9472243', 'Content Delivery', '2017-11-26 04:39:54')")); 

		DB::select(DB::raw("INSERT INTO `login_status` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(7, 7, 'online', '2017-11-26 04:51:03', '2017-11-26 04:51:03'),
(8, 8, 'online', '2017-11-26 04:37:59', '2017-11-26 04:37:59')")); 

		DB::select(DB::raw("INSERT INTO `invitation_notification` (`id`, `team_id`, `new_user`, `team_user`, `read_status`, `created_at`, `updated_at`) VALUES
		(16, 4, 8, 7, 0, '2017-11-26 04:37:55', '2017-11-26 04:37:55'),
		(17, 4, 8, 8, 1, '2017-11-26 04:37:55', '2017-11-26 04:37:55')")); 

		  DB::insert('INSERT INTO `channels` (`id`, `channel_name`, `author_id`) VALUES
		  (?, ?, ?)', ['2', '$2y$10$n5ngsDxdehgvZ3IvZTjBY.s4/N7Tftxi6b5I4c5lbDNgoUHZtb6Ri', '7']); 
		  echo "All tables have been imported with test data successfully."; 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}

}
