     <?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage fino
 * @since Fino 
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */          
             
                         
if ( post_password_required() ) {
    return;
}
?>
                        
    <div class="user-comments">
        <?php if ( have_comments() ) : ?>
            <h2>
                <?php
                    $fino_comments_number = get_comments_number();
                    if ( 1 === $fino_comments_number ) {
                    /* translators: %s: post title */
                    printf( esc_html__( 'One thought on &ldquo;%s&rdquo;','fino' ), get_the_title() );
                } else{
                        printf(
                            /* translators: 1: number of comments, 2: post title */
                            _nx('%1$s Comment found','%1$s comments</h3>',    $fino_comments_number, 'comments title', 'fino' ),
                            esc_html (number_format_i18n( $fino_comments_number ) ),
                            get_the_title()
                        );
                    }
                ?>
            </h2>

           <?php the_comments_navigation(); ?>

           <ul>
                <?php
                     wp_list_comments( array(
                         'style'       => 'ul',
                         'short_ping'  => true,
                         'avatar_size' => 42,
                         'callback' => 'fino_comments',
                    ) );
                ?>
            </ul><!-- .comment-list -->

            <?php the_comments_navigation(); ?>

        <?php endif; // Check for have_comments(). ?>

        <?php
          // If comments are closed and there are comments, let's leave a little note, shall we?
           if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'fino' ) ) :
            ?>
             <p class="no-comments"><?php esc_html__( 'Comments are closed.', 'fino' ); ?></p> 
            <?php endif; ?>
    
        <?php 
            $fino_req      = get_option( 'require_name_email' );
            $fino_aria_req = ( $fino_req ? " aria-required='true'" : '' );

            $fino_comments_args = array
           (
            'submit_button' => '<div class="form-group">'.
              '<input  name="%1$s" type="submit" id="%2$s" class="btn-submit" value="Leave Comment" />'.
            '</div>',

            'title_reply'  =>  __( '<h3>Leave a comment</h3>', 'fino'  ), 
            'comment_notes_after' => '',  
                
            'comment_field' =>  
                '<textarea class="form-control" id="comment" name="comment" placeholder="' . esc_attr( 'Comment here', 'fino' ) . '" rows="12" aria-required="true" '. $fino_aria_req . '>' .
                '</textarea>',

            'fields' => apply_filters( 'comment_form_default_fields', array (
                'author' => '<div >'.               
                    '<input id="author" class="form-control" name="author" placeholder="' . esc_attr( 'Your Name *', 'fino' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                    '" size="30"' . $fino_aria_req . ' /></div>',

            'email' =>'<div>'.
                    '<input id="email" class="form-control" name="email" placeholder="' . esc_attr( 'Your Email *', 'fino' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                    '" size="30"' . $fino_aria_req . ' /></div>',
            
               ) ),
            );
       ?>
    </div> 
            
    <div class="comment-box">
        <?php
          comment_form($fino_comments_args);
        ?>
    </div>