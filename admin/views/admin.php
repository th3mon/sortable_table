<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Sortable_Table
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>

<div class="wrap" id="Sortable_Table">

    <form id="form" action="admin-post.php" method="post">
        <input type="hidden" name="action" value="action_save_data">
        <!-- <input type="hidden" name="page" value="sortable-table"> -->
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        <pre><?php var_dump(Sortable_Table_Admin::get_instance()->getSites()); ?></pre>
        
        <!-- @TODO: Provide markup for your options page here. -->
        
        <p>
            <label for="site-name"><?php _e('site name', Sortable_Table::get_instance()->get_plugin_slug()); ?></label>
            <input type="text" id="site-name" name="site-name">
            <label for="site-url"><?php _e('site url', Sortable_Table::get_instance()->get_plugin_slug()); ?></label>
            <input type="text" id="site-url" name="site-url" data-validate="url">
            <input type="button" id="button-add" value="add" class="toDelete">
        </p>
        
        <table id="table">
            <thead>
                <tr>
                    <th></th>
                    <th>site name</th>
                    <th>url</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" id="checkbox-1"></td>
                    <td class="site-name">google</td>
                    <td class="site-url"><a href="http://google.pl/">http://google.pl/</a></td>
                    <td><input type="button" class="button-delete" id="button-delete-1" name="button-delete-1" value="delete"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="checkbox" id="deleteAll" class="deleteAll"></td>
                    <td colspan="3"><input id="button-delete-selected" type="button" value="<?php _e('delete selected', Sortable_Table::get_instance()->get_plugin_slug()); ?>"></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
