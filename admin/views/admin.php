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

$sites = Sortable_Table_Admin::get_instance()->getSites();
$html = '';

?>

<div class="wrap" id="Sortable_Table">

    <form id="form" action="admin-post.php" method="post">
        <input type="hidden" name="action" value="action_save_data">
        <!-- <input type="hidden" name="page" value="sortable-table"> -->
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        
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
                <?php
                    foreach ($sites as $key => $site) {
                        $html .= '<tr class="site" data-id="' . $site->id . '">';
                        $html .= '<td><input type="checkbox" id="checkbox-' . $site->id . '"></td>';
                        $html .= '<td class="site-name">' . $site->site_name . '</td>';
                        $html .= '<td class="site-url"><a href="' . $site->url . '">' . $site->url . '</a></td>';
                        $html .= '<td><input type="button" class="button-delete" id="button-delete-' . $site->id . '" name="button-delete-' . $site->id . '" value="delete"></td>';
                        $html .= '</tr>';
                    }

                    echo $html;
                ?>
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
