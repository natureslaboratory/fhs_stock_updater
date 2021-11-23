<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://acalebwilson.com
 * @since      1.0.0
 *
 * @package    Fhs_Stock_Updater
 * @subpackage Fhs_Stock_Updater/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fhs_Stock_Updater
 * @subpackage Fhs_Stock_Updater/admin
 * @author     Caleb Wilson <caleb@natureslaboratory.co.uk>
 */
class Fhs_Stock_Updater_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		
		add_action('admin_menu', [&$this, "create_admin_menu"]);
		add_action("admin_post_fhs_su_upload_stock", [&$this, "handle_upload"]);
		// add_action('admin_post');

	}

	public function create_admin_menu(){
		add_menu_page('Upload Stock', 'Upload Stock', 'administrator', "upload-stock", [&$this, "stock_form"]);
	}


	public function stock_form() {
		$fhs_su_upload_nonce = wp_create_nonce( 'fhs_su_upload_stock_form_nonce' );
		?>
		<div class="wrap">
			<?php echo "<h2>" . __( 'Upload Stock', 'upload-stock' ) . "</h2>"; ?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="fhs_su_upload_stock_form" enctype="multipart/form-data">
				<input type="file" name="fhs_su_upload_stock_file" id="fhs_su_upload_stock_file" />
				<input type="hidden" name="action" value="fhs_su_upload_stock">
				<input type="hidden" name="fhs_su_upload_stock_form_nonce" value="<?php echo $fhs_su_upload_nonce; ?>" />
				<input type="submit" name="submit" value="Upload" class="button">
			</form>
		</div>
		<?php 
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fhs_Stock_Updater_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fhs_Stock_Updater_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fhs-stock-updater-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fhs_Stock_Updater_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fhs_Stock_Updater_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fhs-stock-updater-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function handle_upload() {
		echo "Upload!";
		echo "<pre>" . print_r($_FILES, true) . "</pre>";

		// if (count($_FILES) == 0) {
		// 	return;
		// }

		$stream = fopen($_FILES["fhs_su_upload_stock_file"]["tmp_name"], "r");

		$csv = fgetcsv($stream);
		$count = 0;

		while (true) {
			$data = fgetcsv($stream);
			if (!$data) {
				break;
			}

			
			$sku = $data[50];
			$price = $data[18];
			$stock_level = $data[25];

			if ($stock_level < 0) {
				$stock_level = 0;
			}
			
			if (!($sku && $price)) {
				continue;
			}

			// echo "SKU: $sku, Price: $price, Stock: $stock_level <br>";
			
			$product_id = wc_get_product_id_by_sku($sku);
			if (!$product_id) {
				continue;
				// Create Product?
			}

			if ($product_id == 2084) {
				echo "Stock: $stock_level, ";
			}
			
			update_post_meta($product_id, "_manage_stock", "yes");
			update_post_meta($product_id, '_regular_price', (float)$price);
			echo wc_update_product_stock($product_id, $stock_level) . "<br>";
			wc_delete_product_transients($product_id);

			
		}

	}

}
