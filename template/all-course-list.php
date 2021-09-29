<h2 class="ui header"><?php _e('Semua Kelas', 'sejowoo-tutorlms'); ?></h2>
<?php
	$course_ids   = sejowootutor_get_available_courses();
	$user_courses = sejowootutor_get_all_enrolled_courses_by_user();
?>
<div class="ui three column doubling stackable cards item-holder masonry grid">
<?php
	foreach( (array) $course_ids as $course_id ) :
		
		$course = $course_id;
	    
	    setup_postdata($course);

	    include( plugin_dir_path( __FILE__ ) . 'course-card.php' );

	endforeach;
?>
</div>
<?php
	wp_reset_query();
?>