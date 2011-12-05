<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

// Shortcuts
$lang['store_shortcut_list_stores']					= 'Winkel Lijst';
$lang['store_shortcut_add_category']				= 'Categorie Toevoegen';
$lang['store_shortcut_add_product']					= 'Product Toevoegen';
$lang['store_shortcut_list_products']				= 'Producten Lijst';
$lang['store_shortcut_list_categories']				= 'Categorieën Lijst';

// Titles
$lang['store_title_store']         					= 'Winkel';
$lang['store_title_store_index']         			= 'Winkel Lijst';
$lang['store_title_add_store']         				= 'Winkel Toevoegen';
$lang['store_title_edit_store']         			= 'Winkel Bewerken';
$lang['store_title_stats_store']         			= 'Winkel Statistieken';
$lang['store_title_add_category']         			= 'Winkel Categorie Toevoegen';
$lang['store_title_list_category']         			= 'Categorieën Lijst';
$lang['store_title_list_products']         			= 'Producten Lijst';

// Tabs
$lang['store_tab_config']							= 'Winkel Configuratie';
$lang['store_tab_payment_gateways']					= 'Betalings Manieren';
$lang['store_tab_additional_info']					= 'Extra Informatie';

// Fields
$lang['store_settings_name']						= 'Winkel naam';
$lang['store_settings_email']						= 'Winkels standaard email adres';
$lang['store_settings_additional_emails']			= 'Extra email addressen (Splitsen met ",")';
$lang['store_settings_currency']					= 'Standaard valuta';
$lang['store_settings_item_per_page']				= 'Items per Pagina';
$lang['store_settings_show_with_tax']				= 'Toon BTW';
$lang['store_settings_display_stock']				= 'Toon Voorraad';
$lang['store_settings_allow_comments']				= 'Commentaar Toestaan';
$lang['store_settings_new_order_mail_alert']		= 'Mail Alert bij nieuwe orders';
$lang['store_settings_active']						= 'Is actief';
$lang['store_settings_is_default']					= 'Is standaard';

$lang['store_settings_paypal_enabled']				= 'Paypal actief';
$lang['store_settings_paypal_account']				= 'Paypal Account';
$lang['store_settings_paypal_developer_mode']		= 'Ontwikkelaars mode';

$lang['store_settings_authorize_enabled']			= 'Authorize.net actief';
$lang['store_settings_authorize_account']			= 'Authorize.net inloggen';
$lang['store_settings_authorize_secret']			= 'Authorize.net geheim';
$lang['store_settings_authorize_developer_mode']	= 'Ontwikkelaars mode';

$lang['store_settings_twoco_enabled']				= '2Checkout actief';
$lang['store_settings_twoco_account']				= '2Checkout Vender ID';
$lang['store_settings_twoco_developer_mode']		= 'Ontwikkelaars mode';

$lang['store_settings_terms_and_conditions']		= 'Winkel AGB';
$lang['store_settings_privacy_policy']				= 'Winkel Privacybeleid';
$lang['store_settings_delivery_information']		= 'Winkel leverings Informatie';

// Radios
$lang['store_radio_yes']					= ' Ja ';
$lang['store_radio_no']						= ' Nee ';

// Labels
//$lang['store_label_categories']			= 'Categorieën';
//$lang['store_label_upload']				= 'Upload';
//$lang['store_label_manage']				= 'Beheren';
$lang['store_label_store_name']				= 'Winkel Naam';
$lang['store_label_is_default']				= 'Standaard';
$lang['store_label_general_options']		= 'Algemene Opties';
$lang['store_label_email']					= 'Email';
$lang['store_label_email_additional']		= 'Extra Emails';
$lang['store_label_active']					= 'Actief';
$lang['store_label_allow_comments']			= 'Commentaar toestaan';
$lang['store_label_currency']				= 'Valuta';
$lang['store_label_item_per_page']			= 'Objecten per Pagina';
$lang['store_label_display_stock']			= 'Toon Voorraad';
$lang['store_label_statistics']				= 'Statistieken';
$lang['store_label_num_categories']			= '# Categorieën in Winkel';
$lang['store_label_num_products']			= '# Producten in Winkel';
$lang['store_label_num_pending_orders']		= '# uitstaande Orders';
$lang['store_label_actions']				= 'Acties';
// Cart
$lang['store_label_cart_qty']				= 'Aantal';
$lang['store_label_cart_name']				= 'Object Omschrijving';
$lang['store_label_cart_price']				= 'Object Prijs';
$lang['store_label_cart_subtotal']			= 'Sub-Totaal';
$lang['store_label_cart_total']				= 'Totaal';
$lang['store_label_cart_empty']				= 'Uw winkelmand is leeg';
// Widget Cart
$lang['store_label_widget_cart_qty']		= 'Aantal';
$lang['store_label_widget_cart_name']		= 'Naam';
$lang['store_label_widget_cart_empty']		= 'Uw winkelmand is leeg';

// Buttons
$lang['store_button_add_category']			= 'Categorie';
$lang['store_button_add_product']			= 'Product';
$lang['store_button_edit']					= 'Bewerken';
$lang['store_button_delete']				= 'Verwijderen';
//$lang['store_button_preview']				= 'Preview';
$lang['store_button_backup_data']			= 'Backup Data';
$lang['store_button_restore_data']			= 'Herstel Data';
$lang['store_button_set_default']			= 'Set als standaard';
// Cart
$lang['store_button_cart_paypal']			= 'Paypal';
$lang['store_button_cart_update']			= 'Winkelmand bijwerken';
// Widget Cart
$lang['store_button_widget_cart_details']	= 'Details';
$lang['store_button_widget_cart_update']	= 'Bijwerken';

// Messages
$lang['store_messages_no_store_error']		= 'Geen Winkel aangemaakt';
$lang['store_messages_create_success']		= 'Winkel sucessvol aangemaakt';
$lang['store_messages_create_error']		= 'Winkel aanmaken mislukt';
$lang['store_messages_edit_success']		= 'Winkel sucessvol edited';
$lang['store_messages_edit_error']			= 'Winkel bijwerken mislukt';
$lang['store_messages_delete_success']		= 'Winkel sucessvol verwijderd';
$lang['store_messages_delete_error']		= 'Winkel verwijderen mislukt';

// Choices
$lang['store_choice_yes']					= 'Ja';
$lang['store_choice_no']					= 'Nee';