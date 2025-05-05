<?php

$keywords_array = [
  "haste","first strike","flying","menace","fear","intimidate","undying","persist","lifelink",
  "double strike","horsemanship","flanking","deathtouch","trample",
  "afterlife","dredge","scry","surveil","scavenge","madness","ward","hexproof","shroud",
  "banding","rampage","flash","defender","indestructible","reach","phasing","buyback",
  "shadow","cycling","fading","kicker","flashback","morph","amplify","storm","affinity",
  "modular","sunburst","bushido","soulshift","splice","ninjutsu","epic","convoke","transmute",
  "bloodthirst","replicate","forecast","graft","ripple","suspend","vanishing","delve","fortify",
  "gravestorm","poisonous","infect","changeling","evoke","hideaway","prowl","reinforce","conspire",
  "wither","retrace","exalted","unearth","cascade","annihilator","rebound","umbra armor",
  "living weapon","soulbond","overload","unleash","evolve","extort","cipher","bestow","tribute",
  "dethrone","outlast","prowess","dash","exploit","renown","awaken","devoid","myriad","surge",
  "skulk","emerge","melee","crew","fabricate","partner","undaunted","improvise","aftermath","embalm",
  "eternalize","afflict","assist","jump-start","mentor","riot","spectacle","escape","companion",
  "vigilance"];
$mtg_keywords = implode("|", $keywords_array);

$format_tags = '(?:<(?:em|b|i|strong)>)';
$close_ftags = '(?:<\/(?:em|b|i|strong)>)';

$patterns = [
  '/(\.\s|<p>)?'.$format_tags.'((?:\s*)(?<!\[if\])black(?:\s*))(?![a-zA-Z])'.$close_ftags.'/i',
  '/(\.\s|<p>)?'.$format_tags.'?((?:\s*)(?<!\[if\])green(?:\s*))(?![a-zA-Z])'.$close_ftags.'?/i',
  '/(\.\s|<p>)?'.$format_tags.'?((?:\s*)(?<!\[if\])red(?:\s*))(?![a-zA-Z])'.$close_ftags.'?/i',
  '/(\.\s|<p>)?'.$format_tags.'?((?:\s*)(?<!\[if\])white(?:\s*))(?![a-zA-Z])'.$close_ftags.'?/i',
  '/(\.\s|<p>)?'.$format_tags.'?((?:\s*)(?<!\[if\])blue(?:\s*))(?![a-zA-Z])'.$close_ftags.'?/i',
  '/(\[el(?:\svalue=".*")?\]).*?(white|blue|black|red|green).*?(\[\/el\])/i',
  '/(<p>)\d\s.*?(white|blue|black|red|green).*?(<\/p>)/i',
  '/(\d\s).*?(white|blue|black|red|green).*?(")?/i',
  '/(?<!\[el\]).*(\.\s|<p>)?'.$format_tags.'?((?:\s*)(?<!\[if\])colorless(?:\s*))(?![a-zA-Z])'.$close_ftags.'?.*(?!\[\/el\])/i',
  '/(?<!\[if\])'.$format_tags.'?(landfall)'.$close_ftags.'?/i',
  '/(?<!\[if\])(tribal)(?!\[\/if\])/i',
  '/(?<!\[if\])(typal)(?!\[\/if\])/i',
  '/(?<=\.\s|\n<p>)'.$format_tags.'?(kindred)'.$close_ftags.'?/i',
  '/(magic:? the gathering)/i',
  '/<(h1) ?.*>(.*)(<\/h1>)/i',
  '/(?<!\[if\])(?<!<em>)(mtg)/i',
  '/(?<!\[if\])(?<!<em>)(wizards \(?of the coast\)?)/i',
  '/(?<!\[if\])(?<!<em>)(wotc)/i',
  '/(?<!\[if\])(?<!<em>)(universes beyond)/i',
  '/(?<!\[if\])(the commander format)/i',
  '/(?<!\[if\])(equipment)/i',
  '/(?<!\[if\])(aura)/i',
  '/(?<!\[if\])([\w]*ly)-([\w]*)/i',
  '/(\.\s|<p>)?(\[if\])?(?<!\[el\])(?<!\d\s)(?:<(em|b|i|strong)>\s?)*(?<![a-zA-Z])(' . $mtg_keywords . ')(?![a-zA-Z])(?:\s?<\/(em|b|i|strong)>)*/i',
  '/(\[el\]).*?(?<![a-zA-Z])('.$mtg_keywords.')(?![a-zA-Z]).*?(\[\/el\])/i',
];

// string indexed array
// keys are strtolower() of matching groups from $patterns
// if the key doesn't exist, the matching group should be used directly
$replacements = [
  'landfall' => '<em>Landfall</em>',
  'tribal' => 'kindred',
  'typal' => 'kindred',
  'kindred' => 'Kindred',
  'magic the gathering' => 'Magic: the Gathering',
  'mtg' => '<em>MtG</em>',
  'wizards of the coast' => '<em>Wizards (of the Coast)</em>',
  'wotc' => '<em>WotC</em>',
  'equipment' => 'Equipment',
  'aura' => 'Aura',
  'the commander format' => 'Commander',
  'universes beyond' => '<em>Universes Beyond</em>',
];
