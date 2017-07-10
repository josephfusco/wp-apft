<?php
/**
 * Plugin Name:         APFT
 * Plugin URI:          https://github.com/josephfusco/wp-apft
 * Description:         Add an APFT calculator to your site.
 * Version:             1.0.0
 * Author:              Joseph Fusco
 * Author URI:          https://josephfus.co
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         wp-apft
 * GitHub Plugin URI:   josephfusco/wp-apft
 */

define( 'WPAPFT_VERSION', '1.0.0' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Enqueue frontend scripts & styles.
 *
 * @since  1.0.0
 */
function wpapft_register_scripts() {
	wp_register_style( 'apft-style', plugin_dir_url( __FILE__ ) . 'assets/styles/dist/app.min.css', array(), WPAPFT_VERSION );

	wp_register_script( 'jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js', array( 'jquery' ), '1.16.0' );
	wp_register_script( 'apft-script', plugin_dir_url( __FILE__ ) . 'assets/js/dist/app.min.js', array( 'jquery' ), WPAPFT_VERSION );
	wp_localize_script( 'apft-script', 'apft_object',
		array(
			'standards_url' => plugin_dir_url( __FILE__ ) . 'standards.json',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'wpapft_register_scripts' );

/**
 * Calculator shortcode.
 *
 * @since  1.0.0
 *
 * @param  $attr
 */
function wpapft_calculator( $attr ) {

	// Load styles.
	wp_enqueue_style( 'apft-style' );

	// Load scripts.
	wp_enqueue_script( 'jquery-validate' );
	wp_enqueue_script( 'apft-script' );

	ob_start();
	?>
	<div id="apft-application">

		<form id="apft-calculator">

			<div class="input-wrap">
				<label for="gender" class="screen-reader-text">Gender</label>
				<select id="gender" name="gender" class="form-control">
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
			</div>

			<div class="input-wrap">
				<label for="age" class="screen-reader-text">Age Group</label>
				<select id="age" name="age" class="form-control">
					<option value="17-21">17-21</option>
					<option value="22-26">22-26</option>
					<option value="27-31">27-31</option>
					<option value="32-36">32-36</option>
					<option value="37-41">37-41</option>
					<option value="42-46">42-46</option>
					<option value="47-51">47-51</option>
					<option value="52-56">52-56</option>
					<option value="57-61">57-61</option>
					<option value="62+">62+</option>
				</select>
			</div>

			<div class="input-wrap">
				<label for="pu" class="screen-reader-text">Push Ups</label>
				<input placeholder="Push Ups" id="pu" name="pu" type="number" class="form-control input-md">
			</div>

			<div class="input-wrap">
				<label for="su" class="screen-reader-text">Sit-ups</label>
				<input placeholder="Sit-ups" id="su" name="su" type="number" class="form-control input-md">
			</div>

			<div class="input-wrap">
				<label for="min" class="screen-reader-text">Run minutes</label>
				<input placeholder="Run Minutes" id="min" name="min" type="number" class="form-control input-md">
			</div>

			<div class="input-wrap last">
				<label for="sec" class="screen-reader-text">Run seconds</label>
				<input placeholder="Run Seconds" id="sec" name="sec" type="number" class="form-control input-md">
			</div>

			<input id="get_score" class="btn btn-primary" type="submit" value="Get Score">

			<button id="apft-reset" class="btn btn-default">Reset</button>

		</form>

		<div id="apft-results" class="results hidden">

			<table>

				<thead>
					<tr>
						<th>Exercise</th>
						<th>Score</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>Push Ups</td>
						<td class="apft-result-pu-score"></td>
					</tr>
					<tr>
						<td>Sit-Ups</td>
						<td class="apft-result-su-score"></td>
					</tr>
					<tr>
						<td>2 Mile Run</td>
						<td class="apft-result-run-score"></td>
					</tr>
					<tr>
						<td>Total Score</td>
						<td class="apft-result-total-score"></td>
					</tr>
				</tbody>

			</table>

		</div>

		<p class="credit">APFT Calculator developed by <a href="https://josephfus.co" target="_blank">Joseph Fusco</a></p>

	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'apft', 'wpapft_calculator' );
