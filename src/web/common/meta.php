<?php
require_once('../config.inc.php');
header('Content-Type: application/json');
$meta = json_decode(file_get_contents('meta.json'), true);

// Load resource pack textures
$spellJson = json_decode(file_get_contents('../rp/default/assets/minecraft/models/item/diamond_axe.json'), true);
$spellJson = $spellJson['overrides'];
$spellIcons = array();
$diamondUses = 1562;
foreach ($spellJson as $spellPredicate) {
    $durability = round($spellPredicate['predicate']['damage'] * $diamondUses);
    if ($durability == 0) continue;
    $texture = str_replace('item/', '', $spellPredicate['model']);
    $spellIcons['diamond_axe:' . $durability] = '<img src="common/image/' . $texture . '.png" class="spellIcon"/>' . $texture;
}
$meta['types']['spell_icon']['options'] = $spellIcons;

// Populate action, effect and effectlib class types
$actions = array_column($meta['actions'], 'short_class');
$actions = array_fill_keys($actions, null);
$meta['types']['action_class']['options'] = $actions;

$effects = array_column($meta['effectlib_effects'], 'short_class');
$effects = array_fill_keys($effects, null);
$meta['types']['effectlib_class']['options'] = $effects;

$meta['types']['effect_class']['options'] = array('EffectSingle' => null, 'EffectRing' => null, 'EffectTrail' => null);

echo json_encode($meta);