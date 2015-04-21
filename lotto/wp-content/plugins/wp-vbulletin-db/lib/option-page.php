<?
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>
<style>
	.remove-conn, .edit-conn, .add-conn, .cancel-edit, .test-conn {
		text-decoration: none;
	}

	.remove-conn, .cancel-edit {
		color: #ca0000;
		visibility: hidden;
	}

	.edited .remove-conn, .edited .cancel-edit {
		visibility: visible;
	}

	.edited .test-conn {
		visibility: hidden;
	}

	.remove-conn:hover, .cancel-edit:hover {
		color: red
	}

	.connections {
		border-collapse: collapse;
	}
	.connections input {max-width:10em;}
	.connections td {
		padding: 0.3em;
		border: 1px solid #d1d1d1;
	}

	.connections th {
		padding: 0.3em 0.5em;
		border-bottom: 1px solid #ababab;
	}

	.connections input:disabled {
		border: 0;
		background: transparent;
		box-shadow: none;
		color: #333;
	}
	.connections .spinner{float:left;display: block;}

	.add-conn {
		color: #00bf00;
	}

	.add-conn:hover {
		color: #00e900;
	}

	.edited .edit-conn .dashicons:before {
		content: "\f147";
	}
</style>
<script>
	jQuery(document).ready(function ($) {


		$('a.cancel-edit').on('click', function () {
			var id = this.dataset.id;
			$('#conn-' + id + ' input').each(function (i, el) {
				el.value = el.dataset.def;
			})
			$('#conn-' + id).removeClass('edited');
			$('#connections .edit-conn').css('visibility', 'visible');
			$('#connections input').attr('disabled', true);

		});

		$('a.edit-conn').on('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			var id = this.dataset.id;

			if ($('#conn-' + id).is('.edited')) {
				$('#conn-' + id).removeClass('edited');
				$('#connections .edit-conn').css('visibility', 'visible');
				$('#connections input').attr('disabled', true);
				window.onbeforeunload =  function () {return false;};
				return;
			}
			$('#connections tr').removeClass('edited');
			$('#connections input').attr('disabled', true);
			$('#connections .edit-conn').css('visibility', 'hidden');
			$('#conn-' + id + ' input').attr('disabled', false);
			$('#conn-' + id).addClass('edited');
			$(this).css('visibility', 'visible');
		});
		$('#save_options').on('submit', function () {
			$('#connections input').attr('disabled', false);
			if ($('#conn-0-name').val() == '') {
				$('#conn-0 input').val('').attr('disabled', true);
			}
		});
		$('.remove-conn').on('click', function () {
			if (confirm("<?=__('Delete connection?')?>")) {
				$('#conn-' + this.dataset.id).remove();
				alert("<?=__('Save changes to complete deletion')?>")
			}
		});

		var test_conn = function () {
			var url = '<?=admin_url( 'admin-ajax.php' ); ?>';
			var db = {};
			var id = this.dataset.id;
			$('#conn-' + id + ' .spinner, #conn-'+id+' .test-conn').toggle();
			$('#conn-' + id + ' input').each(function (i, el) {
				db[el.dataset.name] = el.value;
			});
			var data = {
				action: '<?=self::AJAX_ACTION?>'
				, db: db
			};
			$('#preview').empty().html('loading.....');
			$.post(
				url
				, data
				, function (resp) {
					$('#preview').html(resp);
					$('#conn-' + id + ' .spinner, #conn-'+id+' .test-conn').toggle();
				}
				, 'html'
			);
		};

		$('.test-conn').on('click', test_conn);
		document.getElementById('save_options').onsubmit=function(){window.onbeforeunload = null;}
	});

</script>
<h1>VBulletin 5.x DB feeds</h1>
<h2>Connections</h2>
<form id="save_options" method="post" action="options.php">
	<? settings_fields( self::DB_SETTINGS_GROUP ); ?>
	<table id="connections" class="connections">
		<tr>
			<th>edit</th>
			<th>connection name</th>
			<th>Database</th>
			<th>User</th>
			<th>password</th>
			<th>host</th>
			<th>Cache time,sec</th>
			<th></th>
		</tr>
		<?
		$i = 10; // !! 0 is for new !!
		foreach ( $options as $db ) {
			$i ++;
			?>
			<tr id="conn-<?= $i ?>">
				<td>
					<a class="cancel-edit" data-id="<?= $i ?>" href="javascript:"><span
							class="dashicons dashicons-no-alt"></span></a>
					<a class="edit-conn" data-id="<?= $i ?>" href="javascript:"><span
							class="dashicons dashicons-edit"></span></a>
				</td>
				<td><input data-def="<?= $db['conn'] ?>" data-name="conn" name="<?= self::DB_CONNECT ?>[<?= $i ?>][conn]"
				           type="text" value="<?= $db['conn'] ?>" disabled="disabled"></td>
				<td><input data-def="<?= $db['db'] ?>" data-name="db" name="<?= self::DB_CONNECT ?>[<?= $i ?>][db]"
				           type="text" value="<?= $db['db'] ?>" disabled="disabled"></td>
				<td><input data-def="<?= $db['user'] ?>" data-name="user"
				           name="<?= self::DB_CONNECT ?>[<?= $i ?>][user]"
				           type="text" value="<?= $db['user'] ?>" disabled="disabled"></td>
				<td><input data-def="<?= $db['pass'] ?>" data-name="pass"
				           name="<?= self::DB_CONNECT ?>[<?= $i ?>][pass]"
				           type="password" value="<?= $db['pass'] ?>" disabled="disabled"></td>
				<td><input data-def="<?= $db['host'] ?>" data-name="host"
				           name="<?= self::DB_CONNECT ?>[<?= $i ?>][host]"
				           type="text" value="<?= $db['host'] ?>" disabled="disabled"></td>
				<td><input data-def="<?= $db['cache'] ?>" data-name="cache"
				           name="<?= self::DB_CONNECT ?>[<?= $i ?>][cache]"
				           type="text" value="<?= $db['cache'] ?>" disabled="disabled"></td>
				<td>
					<a class="test-conn" data-id="<?= $i ?>" href="javascript:"><span
							class="dashicons dashicons-visibility"></span></a>
					<span class="spinner" style="display: none;"></span>
					<a class="remove-conn" data-id="<?= $i ?>" href="javascript:"><span
							class="dashicons dashicons-no-alt"></span>delete</a>
				</td>
			</tr>
		<?
		}

		?>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>"/>
	</p>

	<h2>Add new connection</h2>
	<table id="new-conn" class="connections">
		<tr id="conn-0">
			<td width="40px">&nbsp;</td>
			<td><input id="conn-0-name" name="<?= self::DB_CONNECT ?>[0][conn]" placeholder="connection name"
			           type="text" value="<?= $def_con ?>"></td>
			<td><input name="<?= self::DB_CONNECT ?>[0][db]" placeholder="database name"
			           type="text" value="<?= $def_db_name ?>"></td>
			<td><input name="<?= self::DB_CONNECT ?>[0][user]" placeholder="database user"
			           type="text" value="<?= $def_db_user ?>"></td>
			<td><input name="<?= self::DB_CONNECT ?>[0][pass]" placeholder="database password"
			           type="text" value="<?= $def_db_password ?>"></td>
			<td><input name="<?= self::DB_CONNECT ?>[0][host]" placeholder="database host"
			           type="text" value="<?= $def_db_host ?>">
			<td><input name="<?= self::DB_CONNECT ?>[0][cache]" placeholder="cache time, seconds"
			           type="text" value="<?= $def_db_cache?>">
			</td>


		</tr>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save Changes and add new' ) ?>"/>
	</p>

	<div id="preview">

	</div>
</form>