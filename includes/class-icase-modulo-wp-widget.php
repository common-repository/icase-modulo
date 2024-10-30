<?php

class Login_Widget extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'login_widget', // Base ID
            'iCase login', // Name
            array( 'description' => __( 'Formulário de login - iCase', 'icase-modulo-wp' ), ) // Args
        );
    }
 
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        @session_start();
        
        $mensagem = '';
        
        // Determina se quem está logado é um socio ou não sócio
        $socio = true;
        if(!$_SESSION['status']){
            $socio = false;
        }
        $options = get_option( 'icase_options' );
        $sigla = $options[sigla];
        ?>

        <div class="box-ae-icase">
            <?php if(isset($_SESSION['mensagem_login']) && !empty($_SESSION['mensagem_login'])): ?>
                <strong class="error-message"><?php echo $_SESSION['mensagem_login']; ?></strong>
                <script type="text/javascript">
                    setTimeout("jQuery('.error-message').hide(500)",5000);
                </script>
            <?php unset($_SESSION['mensagem_login']); endif; ?>
                <?php if(isset($_SESSION['logado']) && $_SESSION['logado'] == true): ?>
                    <ul>
                        <li><?php echo __('Bem vindo(a)') ?>: <strong><?php echo $_SESSION['nome']; ?></strong></li>
                        <li><a href="<?php bloginfo('url'); ?>espaco-do-associado" title="<?php echo __('Espaço do Associado') ?>"><?php echo __('Espaço do Associado') ?></a></li>
                        <li><a href="<?php bloginfo('url'); ?>?act=logoff" title="<?php echo __('Sair') ?>"><?php echo __('Sair') ?></a></li>
                    </ul>
                <?php else: ?>            
                    <form method="POST" action="">
                        <input type="text" id="cpf" placeholder="<?php echo __('Digite seu CPF/E-mail') ?>" name="login[login]">
                        <input type="password" id="senha" name="login[senha]" placeholder="<?php echo __('Digite sua senha') ?>">
                        <input type="hidden" value="icase" name="sis">
                        <input type="submit" name="op" value="<?php echo __('Entrar') ?>" class="">
                    </form>
                    <a href="https://icase.<?php echo $sigla ?>.itarget.com.br/estacao/index/esqueci-minha-senha" title="<?php echo __('Esqueci minha senha') ?>" target="_blank"><?php echo __('Esqueci minha senha') ?></a> 
                <?php endif; ?>
        </div>
        <?php
        echo $after_widget;
    }
 
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( '', 'icase-modulo-wp' );
        }
        ?>
        <p>
        <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Título:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }
 
} // class Login_Widget

// Register Foo_Widget widget
add_action( 'widgets_init', function() { register_widget( 'Login_Widget' ); } );