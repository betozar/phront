<nav>
	<ul>
		<li>
			<a href="/"><?=APP_NAME?></a>
		</li>
		<li>
			<?=__('Select language')?>
			<form 
				action="/api/lang/change" 
				method="POST">
				<select 
					name="l" 
					id="form_lang_change_value">
					<?php foreach( APP_LANG_SUPPORTED as $lv ): ?>
						<option 
							value="<?=$lv?>" 
							<?=($lv === session_lang_get()? 'selected' : '')?>
						>
							<?=$lv?>
						</option>
					<?php endforeach; ?>
				</select>
				<input 
					type="submit" 
					value="<?=__('Send')?>">
			</form>
		</li>
		<?php if( auth_is_active() ): ?>
			<li>
				<a href="/account"><?=__('My Account')?></a>
			</li>
			<li>
				<form action="/api/auth/logout" method="POST">
					<button type="submit"><?=__('Logout')?></button>
				</form>
			</li>
		<?php else: ?>
			<li>
				<a href="/auth/login"><?=__('Login')?></a>
			</li>
			<li>
				<a href="/auth/register"><?=__('Register')?></a>
			</li>
		<?php endif; ?>
	</ul>
</nav>
