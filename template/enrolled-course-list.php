<h2 class="ui header"><?php _e('Kelas Anda', 'sejowoo-tutorlms'); ?></h2>
<?php
    $course_ids   = sejowootutor_get_available_courses();
    $user_courses = sejowootutor_get_all_enrolled_courses_by_user();
?>
<div class="ui three column doubling stackable cards item-holder masonry grid">
<?php
	foreach( $user_courses as $user_course ) :

	    $course = $user_course;
	    
	    setup_postdata($course);

	    include( plugin_dir_path( __FILE__ ) . 'course-card.php' );

	endforeach;
?>
</div>
<?php
    wp_reset_query();
?>