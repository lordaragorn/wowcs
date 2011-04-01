        //<![CDATA[
        var MsgProfile = {
            tooltip: {
                feature: {
                    notYetAvailable: "This feature is not yet available."
                },
                vault: {
                    character: "This section is only accessible if you are logged in as this character.",
                    guild: "This section is only accessible if you are logged in as a character belonging to this guild."
                }
            }
        };
        var MsgSummary = {
            viewOptions: {
                threed: {
                    title: "3D View"
                }
            },
            inventory: {
                slots: {
                    1: "Head",
                    2: "Neck",
                    3: "Shoulder",
                    4: "Shirt",
                    5: "Chest",
                    6: "Waist",
                    7: "Legs",
                    8: "Feet",
                    9: "Wrist",
                    10: "Hands",
                    11: "Finger",
                    12: "Trinket",
                    15: "Ranged",
                    16: "Back",
                    19: "Tabard",
                    21: "Main Hand",
                    22: "Off Hand",
                    28: "Relic",
                    empty: "This slot is empty."
                }
            },
            audit: {
                whatIsThis: "This feature makes recommendations on how this character can be improved. The following is verified:<br /\><br /\>- Empty glyph slots<br /\>- Unspent talent points<br /\>- Unenchanted items<br /\>- Empty sockets<br /\>- Non-optimal armour<br /\>- Missing belt buckle<br /\>- Unused profession perks",
                missing: "Missing {0}",
                enchants: {
                    tooltip: "Unenchanted"
                },
                sockets: {
                    singular: "empty socket",
                    plural: "empty sockets"
                },
                armor: {
                    tooltip: "Non-{0}",
                    1: "Cloth",
                    2: "Leather",
                    3: "Mail",
                    4: "Plate"
                },
                lowLevel: {
                    tooltip: "Low level"	
                },
                blacksmithing: {
                    name: "Blacksmithing",
                    tooltip: "Missing socket"
                },
                enchanting: {
                    name: "Enchanting",
                    tooltip: "Unenchanted"
                },
                engineering: {
                    name: "Engineering",
                    tooltip: "Missing tinker"
                },
                inscription: {
                    name: "Inscription",
                    tooltip: "Missing enchant"
                },
                leatherworking: {
                    name: "Leatherworking",
                    tooltip: "Missing enchant"
                }
            },
            talents: {
                specTooltip: {
                    title: "Talent Specializations",
                    primary: "Primary:",
                    secondary: "Secondary:",
                    active: "Active"
                }
            },
            stats: {
                toggle: {
                    all: "Show all stats",
                    core: "Show core stats only"
                },
                increases: {
                    attackPower: "Increases Attack Power by {0}.",
                    critChance: "Increases Crit chance by {0}%.",
                    spellCritChance: "Increases Spell Crit chance by {0}%.",
                    health: "Increases Health by {0}.",
                    mana: "Increases Mana by {0}.",
                    manaRegen: "Increases mana regeneration by {0} every 5 seconds while not casting.",
                    meleeDps: "Increases damage with melee weapons by {0} damage per second.",
                    rangedDps: "Increases damage with ranged weapons by {0} damage per second.",
                    petArmor: "Increases your pet’s Armour by {0}.",
                    petAttackPower: "Increases your pet’s Attack Power by {0}.",
                    petSpellDamage: "Increases your pet’s Spell Damage by {0}.",
                    petAttackPowerSpellDamage: "Increases your pet’s Attack Power by {0} and Spell Damage by {1}."
                },
                decreases: {
                    damageTaken: "Reduces Physical Damage taken by {0}%.",
                    enemyRes: "Reduces enemy resistances by {0}.",
                    dodgeParry: "Reduces chance to be dodged or parried by {0}%."
                },
                noBenefits: "Provides no benefit for your class.",
                beforeReturns: "(Before diminishing returns)",
                damage: {
                    speed: "Attack speed (seconds):",
                    damage: "Damage:",
                    dps: "Damage per second:"
                },
                averageItemLevel: {
                    title: "Item Level {0}",
                    description: "The average item level of your best equipment. Increasing this will allow you to enter more difficult dungeons using Dungeon Finder."
                },
                health: {
                    title: "Health {0}",
                    description: "Your maximum amount of health. If your health reaches zero, you will die."
                },
                mana: {
                    title: "Mana {0}",
                    description: "Your maximum mana. Mana allows you to cast spells."
                },
                rage: {
                    title: "Rage {0}",
                    description: "Your maximum rage. Rage is consumed when using abilities and is restored by attacking enemies or being damaged in combat."
                },
                focus: {
                    title: "Focus {0}",
                    description: "Your maximum focus. Focus is consumed when using abilities and is restored automatically over time."
                },
                energy: {
                    title: "Energy {0}",
                    description: "Your maximum energy. Energy is consumed when using abilities and is restored automatically over time."
                },
                runic: {
                    title: "Runic {0}",
                    description: "Your maximum Runic Power."
                },
                strength: {
                    title: "Strength {0}"
                },
                agility: {
                    title: "Agility {0}"
                },
                stamina: {
                    title: "Stamina {0}"
                },
                intellect: {
                    title: "Intellect {0}"
                },
                spirit: {
                    title: "Spirit {0}"
                },
                mastery: {
                    title: "Mastery {0}",
                    description: "Mastery rating of {0} adds {1} Mastery.",
                    unknown: "You must learn Mastery from your trainer before this will have an effect.",
                    unspecced: "You must select a talent specialization in order to activate Mastery."
                },
                meleeDps: {
                    title: "Damage per Second"
                },
                meleeAttackPower: {
                    title: "Melee Attack Power {0}"
                },
                meleeSpeed: {
                    title: "Melee Attack Speed {0}"
                },
                meleeHaste: {
                    title: "Melee Haste {0}%",
                    description: "Haste rating of {0} adds {1}% Haste.",
                    description2: "Increases melee attack speed."
                },
                meleeHit: {
                    title: "Melee Hit Chance {0}%",
                    description: "Hit rating of {0} adds {1}% Hit chance."
                },
                meleeCrit: {
                    title: "Melee Crit Chance {0}%",
                    description: "Crit rating of {0} adds {1}% Crit chance.",
                    description2: "Chance of melee attacks doing extra damage."
                },
                expertise: {
                    title: "Expertise {0}",
                    description: "Expertise rating of {0} adds {1} Expertise."
                },
                rangedDps: {
                    title: "Damage per Second"
                },
                rangedAttackPower: {
                    title: "Ranged Attack Power {0}"
                },
                rangedSpeed: {
                    title: "Ranged Attack Speed {0}"
                },
                rangedHaste: {
                    title: "Ranged Haste {0}%",
                    description: "Haste rating of {0} adds {1}% Haste.",
                    description2: "Increases ranged attack speed."
                },
                rangedHit: {
                    title: "Ranged Hit Chance {0}%",
                    description: "Hit rating of {0} adds {1}% Hit chance."
                },
                rangedCrit: {
                    title: "Ranged Crit Chance {0}%",
                    description: "Crit rating of {0} adds {1}% Crit chance.",
                    description2: "Chance of ranged attacks doing extra damage."
                },
                spellPower: {
                    title: "Spell Power {0}",
                    description: "Increases the damage and healing of spells."
                },
                spellHaste: {
                    title: "Spell Haste {0}%",
                    description: "Haste rating of {0} adds {1}% Haste.",
                    description2: "Increases spell casting speed."
                },
                spellHit: {
                    title: "Spell Hit Chance {0}%",
                    description: "Hit rating of {0} adds {1}% Hit chance."
                },
                spellCrit: {
                    title: "Spell Crit Chance {0}%",
                    description: "Crit rating of {0} adds {1}% Crit chance.",
                    description2: "Chance of spells doing extra damage or healing."
                },
                spellPenetration: {
                    title: "Spell Penetration {0}"
                },
                manaRegen: {
                    title: "Mana Regen",
                    description: "{0} mana regenerated every 5 seconds while not in combat."
                },
                combatRegen: {
                    title: "Combat Regen",
                    description: "{0} mana regenerated every 5 seconds while in combat."
                },
                armor: {
                    title: "Armour {0}"
                },
                dodge: {
                    title: "Dodge Chance {0}%",
                    description: "Dodge rating of {0} adds {1}% Dodge chance."
                },
                parry: {
                    title: "Parry Chance {0}%",
                    description: "Parry rating of {0} adds {1}% Parry chance."
                },
                block: {
                    title: "Block Chance {0}%",
                    description: "Block rating of {0} adds {1}% Block chance.",
                    description2: "Your block stops {0}% of incoming damage."
                },
                resilience: {
                    title: "Resilience {0}",
                    description: "Provides {0}% damage reduction against all damage done by players and their pets or minions."
                },
                arcaneRes: {
                    title: "Arcane Resistance {0}",
                    description: "Reduces Arcane damage taken by an average of {0}%."
                },
                fireRes: {
                    title: "Fire Resistance {0}",
                    description: "Reduces Fire damage taken by an average of {0}%."
                },
                frostRes: {
                    title: "Frost Resistance {0}",
                    description: "Reduces Frost damage taken by an average of {0}%."
                },
                natureRes: {
                    title: "Nature Resistance {0}",
                    description: "Reduces Nature damage taken by an average of {0}%."
                },
                shadowRes: {
                    title: "Shadow Resistance {0}",
                    description: "Reduces Shadow damage taken by an average of {0}%."
                }
            },
            recentActivity: {
                subscribe: "Subscribe to this feed"
            },
            raid: {
                tooltip: {
                    normal: "(Normal)",
                    heroic: "(Heroic)",
                    players: "{0} players",
                    complete: "{0}% complete ({1}/{2})",
                    optional: "(optional)",
                    expansions: {
                            0: "Classic",
                            1: "The Burning Crusade",
                            2: "Wrath of the Lich King",
                            3: "Cataclysm"
                    }
                },
                expansions: {
                        0: "Classic",
                        1: "The Burning Crusade",
                        2: "Wrath of the Lich King",
                        3: "Cataclysm"
                }
            }
        };
	//]]>