<?php

namespace inc\admin_settings;

use inc\fortnox\WF_Plugin;

if ( ! function_exists( 'format_tooltip' ) ) {
	function format_tooltip( $tip ): string {
		return '<span class="woocommerce-help-tip" data-tip="' . esc_attr( $tip ) . '"></span>';
	}
}

if ( ! function_exists( 'format_html_tooltip' ) ) {
	function format_html_tooltip( $tip ): string {
		return '<span class="woocommerce-help-tip" data-tip="' . wc_sanitize_tooltip( $tip ) . '"></span>';
	}
}

/* @var $header string */
/* @var $title string */
/* @var $hasTabs bool */
/* @var $buy bool */
/* @var $tabs array */
/* @var $hidden string */
/* @var $sections array */
/* @var $saveButton string */

$link_icon = '<svg class="link-icon" width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M5.14286 1.14286C5.14286 0.787277 5.43013 0.5 5.78571 0.5H8.35714C8.71272 0.5 9 0.787277 9 1.14286V3.71429C9 4.06987 8.71272 4.35714 8.35714 4.35714C8.00156 4.35714 7.71429 4.06987 7.71429 3.71429V2.69576L4.31317 6.09888C4.06205 6.35 3.65424 6.35 3.40313 6.09888C3.15201 5.84777 3.15201 5.43996 3.40313 5.18884L6.80424 1.78571H5.78571C5.43013 1.78571 5.14286 1.49844 5.14286 1.14286ZM0 2.75C0 1.86205 0.719196 1.14286 1.60714 1.14286H3.21429C3.56987 1.14286 3.85714 1.43013 3.85714 1.78571C3.85714 2.14129 3.56987 2.42857 3.21429 2.42857H1.60714C1.43036 2.42857 1.28571 2.57321 1.28571 2.75V7.89286C1.28571 8.06964 1.43036 8.21429 1.60714 8.21429H6.75C6.92679 8.21429 7.07143 8.06964 7.07143 7.89286V6.28571C7.07143 5.93013 7.35871 5.64286 7.71429 5.64286C8.06987 5.64286 8.35714 5.93013 8.35714 6.28571V7.89286C8.35714 8.7808 7.63795 9.5 6.75 9.5H1.60714C0.719196 9.5 0 8.7808 0 7.89286V2.75Z" fill="black"/>
			</svg>';

if ( $header ): ?>
	<section id="wetail-header"><?= $header ?></section>
<?php endif; ?>
<div class="wrap fortnox-admin-settings">
	<h1><?= $title ?>
		<?php if ( $buy ): ?>
			<a href="https://wetail.io/service/intergrationer/woocommerce-fortnox/"
			   class="button-primary page-title-action" target="_blank">Order License</a>
		<?php endif; ?>
	</h1>

	<?php if ( $hasTabs ): ?>
		<div class="nav-tab-wrapper">
			<?php foreach ( $tabs as $tab ): ?>
				<?php $is_upgrades_available = get_option( 'fortnox_upgrades_available', 'yes' ) === 'yes' ?>
				<?php $icon = ''; ?>
				<?php if ( ! $tab[ 'selected' ] && $tab[ 'name' ] === 'upgrades' && $is_upgrades_available ) {
					$icon = '<svg class="warning-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="9" cy="9" r="9" fill="#B64D45"/>
						<path d="M10.1346 4.54545L9.95455 11.1655H8.26491L8.08026 4.54545H10.1346ZM9.10973 14.12C8.80504 14.12 8.54344 14.0123 8.32493 13.7969C8.10642 13.5784 7.9987 13.3168 8.00178 13.0121C7.9987 12.7105 8.10642 12.4519 8.32493 12.2365C8.54344 12.0211 8.80504 11.9134 9.10973 11.9134C9.40211 11.9134 9.65909 12.0211 9.88068 12.2365C10.1023 12.4519 10.2146 12.7105 10.2177 13.0121C10.2146 13.2152 10.1607 13.4014 10.0561 13.5707C9.95455 13.7369 9.82067 13.8707 9.65447 13.9723C9.48828 14.0708 9.3067 14.12 9.10973 14.12Z" fill="#C3C4C7"/>
						</svg>
						';
				} ?>
				<a class="nav-tab nav-tab-<?= $tab[ 'name' ] ?> <?= $tab[ 'selected' ] ? 'nav-tab-active' : '' ?> <?= $tab[ 'class' ] ?>"
				   href="options-general.php?page=fortnox&tab=<?= $tab[ 'name' ] ?>">
					<?= $tab[ 'title' ] ?>
					<?= $icon; ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php
	if ( $_REQUEST[ 'page' ] === 'fortnox' && $_REQUEST[ 'tab' ] === 'upgrades' ):
		update_option( 'fortnox_upgrades_available', 'no' );
	endif;
	?>

	<?php
	if ( count( $sections ) > 1 ): ?>
		<ul class="subsubsub">
			<?php foreach ( $sections as $index => $section ): ?>
				<?php $section = $section[ 'section' ];
				$current_page  = admin_url( sprintf( 'admin.php?%s', http_build_query( $_GET ) ) );
				$title         = ! empty( $section[ 'title' ] ) ? $section[ 'title' ] : str_replace( '-', ' ', ucfirst( $section[ 'name' ] ) );
				?>
				<li>
					<a data-section="<?= $section[ 'name' ] ?>"
					   href="<?= $current_page . '&section=' . $section[ 'name' ] ?>"><?= $title ?></a> <?= count( $sections ) - 1 !== $index ? '|' : '' ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php $selected_tab = array_column( $tabs, null, 'selected' )[ 1 ][ 'name' ] ?: ''; ?>

	<div class="fortnox-admin-section<?= count( $sections ) <= 1 ? ' no-subsubsub' : '' ?> <?= $selected_tab ?>">
		<form method="post" action="options.php">
			<?= $hidden ?>
			<?php foreach ( $sections as $section ): ?>
				<?php $section = $section[ 'section' ] ?>
				<div class="fortnox-section" data-section-id="<?= $section[ 'name' ] ?>">
					<?php if ( $section[ 'title' ] ): ?>
						<h2 class="title"><?= $section[ 'title' ] ?></h2>
					<?php endif; ?>

					<?php if ( $section[ 'description' ] ): ?>
						<p><?= $section[ 'description' ] ?></p>
					<?php endif; ?>

					<?php if ( $selected_tab === 'upgrades' ): ?>
						<div class="upgrades">
							<ul class="upgrades__list">
								<?php foreach ( $section[ 'fields' ] as $field ): ?>
									<?php $field = $field[ 'field' ] ?>
									<?php if ( $field[ 'custom_html' ] ): ?>
										<?php echo $field[ 'custom_html' ]; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php else: ?>
						<table class="form-table">
							<tbody>
							<?php foreach ( $section[ 'fields' ] as $index => $field ): ?>
								<?php $field = $field[ 'field' ] ?>
								<tr>
									<th scope="row"><?= $field[ 'title' ] ?></th>
									<td>
										<?php if ( $field[ 'info' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<span><?= $field[ 'value' ] ?></span>
										<?php endif; ?>

										<?php if ( $field[ 'custom_html' ] ): ?>
											<?php echo $field[ 'custom_html' ]; ?>
										<?php endif; ?>

										<?php if ( $field[ 'text' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<input type="text" name="<?= $field[ 'name' ] ?>"
											       value="<?= $field[ 'value' ] ?>"
											       class="<?= $field[ 'class' ] ?><?= $field[ 'short' ] ? ' short-text' : '' ?>"
											       autocomplete="off" placeholder="<?= $field[ 'placeholder' ] ?>">
										<?php endif; ?>

										<?php if ( $field[ 'number' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<input
												type="number" <?= $field[ 'min' ] ? "min=\"{$field['min']}\"" : '' ?> <?= $field[ 'max' ] ? "max=\"{$field['max']}\"" : '' ?>
												name="<?= $field[ 'name' ] ?>" value="<?= $field[ 'value' ] ?>"
												class="<?= $field[ 'class' ] ?>" autocomplete="off"
												placeholder="<?= $field[ 'placeholder' ] ?>">
										<?php endif; ?>

										<?php if ( $field[ 'password' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<input type="password" name="<?= $field[ 'name' ] ?>"
											       value="<?= $field[ 'selected' ] ?>" class="<?= $field[ 'class' ] ?>"
											       autocomplete="off" placeholder="<?= $field[ 'placeholder' ] ?>">
										<?php endif; ?>

										<?php if ( $field[ 'dropdown' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<select name="<?= $field[ 'name' ] ?>"
											        class="<?= $field[ 'class' ] ?><?= $field[ 'short' ] ? ' short-text' : '' ?>">
												<?php foreach ( $field[ 'options' ] as $option ): ?>
													<?php $option = $option[ 'option' ] ?>
													<option
														value="<?= $option[ 'value' ] ?>" <?= $option[ 'selected' ] ? 'selected="selected"' : '' ?>><?= $option[ 'label' ] ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>

										<?php if ( $field[ 'radio' ] ): ?>
											<?php foreach ( $field[ 'options' ] as $option ): ?>
												<?php $option = $field[ 'option' ] ?>

												<p>
													<label>
														<?php if ( $option[ 'tooltip' ] ): ?>
															<?php echo format_tooltip( $option[ 'tooltip' ] ); ?>
														<?php endif; ?>
														<?php if ( $option[ 'html_tooltip' ] ): ?>
															<?php echo format_html_tooltip( $option[ 'html_tooltip' ] ); ?>
														<?php endif; ?>
														<input type="radio" name="<?= $field[ 'name' ] ?>"
														       value="<?= $option[ 'value' ] ?>" <?= $option[ 'selected' ] ? 'checked="checked"' : '' ?>
														       class="<?= $option[ 'class' ] ?>"> <?= $option[ 'label' ] ?>
													</label>
												</p>
											<?php endforeach; ?>
										<?php endif; ?>

										<?php if ( $field[ 'checkbox' ] ): ?>
											<p>
												<input type="hidden" name="<?= $field[ 'name' ] ?>" value="0">
												<label>
													<?php if ( $field[ 'tooltip' ] ): ?>
														<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
													<?php endif; ?>
													<?php if ( $field[ 'html_tooltip' ] ): ?>
														<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
													<?php endif; ?>
													<input type="checkbox" name="<?= $field[ 'name' ] ?>"
													       value="1" <?= $field[ 'checked' ] ? 'checked="checked"' : '' ?>
													       class="<?= $field[ 'class' ] ?>"> <?= $field[ 'label' ] ?>
												</label>
											</p>
										<?php endif; ?>

										<?php if ( $field[ 'checkboxes' ] ): ?>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?= $field[ 'title' ] ?></span>
												</legend>

												<?php foreach ( $field[ 'options' ] as $option ): ?>
													<?php $option = $option[ 'option' ] ?>
													<label>
														<?php if ( $option[ 'tooltip' ] ): ?>
															<?php echo format_tooltip( $option[ 'tooltip' ] ); ?>
														<?php endif; ?>
														<?php if ( $option[ 'html_tooltip' ] ): ?>
															<?php echo format_html_tooltip( $option[ 'html_tooltip' ] ); ?>
														<?php endif; ?>
														<input type="hidden" name="<?= $option[ 'name' ] ?>" value="0">
														<input type="checkbox" name="<?= $option[ 'name' ] ?>"
														       value="1" <?= $option[ 'checked' ] ? 'checked="checked"' : '' ?>
														       class="<?= $option[ 'class' ] ?>"> <?= $option[ 'label' ] ?>
													</label>
													<?php if ( $option[ 'description' ] ): ?>
														<p class="description"><?= $option[ 'description' ] ?></p>
													<?php endif; ?>
												<?php endforeach; ?>
											</fieldset>
										<?php endif; ?>

										<?php if ( $field[ 'table' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<table
												class="wp-list-table widefat fixed striped posts <?= $field[ 'class' ] ?>">
												<thead>
												<tr>
													<?php foreach ( $field[ 'list' ][ 'columns' ] as $column ): ?>
														<th class="column-<?= $column[ 'name' ] ?>"><?= $column[ 'title' ] ?></th>
													<?php endforeach; ?>
												</tr>
												</thead>
												<tbody <?= $field[ 'id' ] ? "id=\"{$field['id']}\"" : '' ?>>
												<?php foreach ( $field[ 'list' ][ 'rows' ] as $row ): ?>
													<?php include( 'admin/settings/field/list-row.php' ); ?>
												<?php endforeach; ?>
												</tbody>
											</table>

											<?php if ( $field[ 'list' ][ 'addRowButton' ] ): ?>
												<p><a href="#"
												      class="button <?= $field[ 'list' ][ 'addRowButtonClass' ] ?>">Add
														row</a></p>
											<?php endif; ?>
										<?php endif; ?>

										<?php if ( $field[ 'html' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>
											<?= $field[ 'html' ] ?>
										<?php endif; ?>

										<?php if ( $field[ 'button' ] ): ?>
											<?php if ( $field[ 'tooltip' ] ): ?>
												<?php echo format_tooltip( $field[ 'tooltip' ] ); ?>
											<?php endif; ?>
											<?php if ( $field[ 'html_tooltip' ] ): ?>
												<?php echo format_html_tooltip( $field[ 'html_tooltip' ] ); ?>
											<?php endif; ?>

											<?php $data_attributes = ''; ?>

											<?php if ( $field[ 'data' ] ):
												foreach ( $field[ 'data' ] as $data ):
													$data_attributes .= "data-{$data['key']}={$data['value']} ";
												endforeach;
											endif; ?>

											<a href="#"
											   class="button button-primary button-hero fortnox-bulk-action" <?= $data_attributes ?>
											   style="text-align: center; width: 240px"><?= $field[ 'button' ][ 'text' ] ?></a>
											<span class="spinner fortnox-spinner hero"></span>
										<?php endif; ?>

										<?php if ( $field[ 'after' ] ): ?>
											<?= $field[ 'after' ] ?>
										<?php endif; ?>

										<?php if ( $field[ 'description' ] ): ?>
											<p class="description"><?= $field[ 'description' ] ?></p>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>

					<?php endif; ?>

				</div>
			<?php endforeach; ?>

			<?php if ( $selected_tab !== 'upgrades' && $selected_tab !== 'general' && $saveButton ): ?>
				<p class="submit">
					<button class="button-primary"><?= $saveButton ?></button>
				</p>
			<?php endif; ?>
		</form>
		<?php if ( $selected_tab !== 'upgrades' ): ?>
			<div class="fortnox-onboarding-assistant">
				<div class="fortnox-onboarding-assistant__header">
					<?php echo '<h4>' . __( 'Onboarding assistance', WF_Plugin::TEXTDOMAIN ) . '</h4>'; ?>
				</div>
				<div class="fortnox-onboarding-assistant__list">
					<a class="fortnox-onboarding-assistant__item"
					   href="https://docs.wetail.io/woocommerce/fortnox-integration/fortnox-installationsguide/"
					   target="_blank">
						<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
							      d="M0 2.625C0 1.17578 1.15179 0 2.57143 0H10.2857H11.1429C11.617 0 12 0.391016 12 0.875V9.625C12 10.109 11.617 10.5 11.1429 10.5V12.25C11.617 12.25 12 12.641 12 13.125C12 13.609 11.617 14 11.1429 14H10.2857H2.57143C1.15179 14 0 12.8242 0 11.375V2.625ZM9.42857 10.5H2.57143C2.09732 10.5 1.71429 10.891 1.71429 11.375C1.71429 11.859 2.09732 12.25 2.57143 12.25H9.42857V10.5ZM3.42857 3.9375C3.42857 3.69688 3.62143 3.5 3.85714 3.5H9C9.23571 3.5 9.42857 3.69688 9.42857 3.9375C9.42857 4.17812 9.23571 4.375 9 4.375H3.85714C3.62143 4.375 3.42857 4.17812 3.42857 3.9375ZM9 5.25H3.85714C3.62143 5.25 3.42857 5.44688 3.42857 5.6875C3.42857 5.92812 3.62143 6.125 3.85714 6.125H9C9.23571 6.125 9.42857 5.92812 9.42857 5.6875C9.42857 5.44688 9.23571 5.25 9 5.25Z"
							      fill="#077BBB"/>
						</svg>
						<span><?php echo __( 'Onboarding documentation', WF_Plugin::TEXTDOMAIN ); ?></span>
						<?= $link_icon ?>
					</a>
					<a class="fortnox-onboarding-assistant__item"
					   href="https://docs.wetail.io/woocommerce/fortnox-integration/fortnox-installationsguide/"
					   target="_blank">
						<svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
							      d="M10.6883 0.239292C11.2046 0.370979 11.6112 0.759021 11.7492 1.25173C12 2.14479 12 4.00808 12 4.00808C12 4.00808 12 5.87138 11.7492 6.76444C11.6112 7.25715 11.2046 7.62902 10.6883 7.76071C9.75249 8 6 8 6 8C6 8 2.24751 8 1.31168 7.76071C0.795387 7.62902 0.388762 7.25715 0.250752 6.76444C0 5.87138 0 4.00808 0 4.00808C0 4.00808 0 2.14479 0.250752 1.25173C0.388762 0.759021 0.795387 0.371 1.31168 0.239292C2.24751 0 6 0 6 0C6 0 9.75251 0 10.6883 0.239292ZM7.90907 4.00813L4.77272 2.31635V5.69981L7.90907 4.00813Z"
							      fill="#077BBB"/>
						</svg>
						<span><?php echo __( 'Video instructions', WF_Plugin::TEXTDOMAIN ); ?></span>
						<?= $link_icon ?>

					</a>
					<a class="fortnox-onboarding-assistant__item" href="https://wetail.io/support/" target="_blank">
						<svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
							      d="M1.33333 0C0.597917 0 0 0.597917 0 1.33333V3C0.552083 3 1 3.44792 1 4C1 4.55208 0.552083 5 0 5V6.66667C0 7.40208 0.597917 8 1.33333 8H10.6667C11.4021 8 12 7.40208 12 6.66667V5C11.4479 5 11 4.55208 11 4C11 3.44792 11.4479 3 12 3V1.33333C12 0.597917 11.4021 0 10.6667 0H1.33333ZM2.66667 6H9.33333V2H2.66667V6ZM2.66667 1.33333C2.29792 1.33333 2 1.63125 2 2V6C2 6.36875 2.29792 6.66667 2.66667 6.66667H9.33333C9.70208 6.66667 10 6.36875 10 6V2C10 1.63125 9.70208 1.33333 9.33333 1.33333H2.66667Z"
							      fill="#077BBB"/>
						</svg>
						<span><?php echo __( 'Support', WF_Plugin::TEXTDOMAIN ); ?></span>
						<?= $link_icon ?>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
