        //<![CDATA[
        var MsgProfile = {
            tooltip: {
                feature: {
                    notYetAvailable: "Эта функция пока не доступна."
                },
                vault: {
                    character: "Этот раздел доступен только для авторизованных пользователей.",
                    guild: "Этот раздел доступен, только если вы авторизовались с персонажа — члена данной гильдии."
                }
            }
        };
        var MsgSummary = {
            viewOptions: {
                threed: {
                    title: "Модель в 3D"
                }
            },
            inventory: {
                slots: {
                    1: "Голова",
                    2: "Шея",
                    3: "Плечи",
                    4: "Рубашка",
                    5: "Грудь",
                    6: "Пояс",
                    7: "Ноги",
                    8: "Ступни",
                    9: "Запястья",
                    10: "Руки",
                    11: "Палец",
                    12: "Аксессуар",
                    15: "Дальний бой",
                    16: "Спина",
                    19: "Гербовая накидка",
                    21: "Правая рука",
                    22: "Левая рука",
                    28: "Реликвия",
                    empty: "Эта ячейка пуста"
                }
            },
            audit: {
                whatIsThis: "С помощью этой функции вы можете узнать, как улучшить характеристики своего персонажа. Функция ищет:<br /\><br /\>- пустые ячейки символов;<br /\>- неиспользованные очки талантов;<br /\>- незачарованные предметы;<br /\>- пустые гнезда для самоцветов;<br /\>- неподходящую броню;<br /\>- отсутствующую пряжку в поясе;<br /\>- отсутствующие бонусы за профессии.",
                missing: "Не хватает: {0}",
                enchants: {
                    tooltip: "Не зачаровано"
                },
                sockets: {
                    singular: "пустое гнездо",
                    plural: "пустые гнезда"
                },
                armor: {
                    tooltip: "Не{0}",
                    1: "Ткань",
                    2: "Кожа",
                    3: "Кольчуга",
                    4: "Латы"
                },
                lowLevel: {
                    tooltip: "Низкий уровень"    
                },
                blacksmithing: {
                    name: "Кузнечное дело",
                    tooltip: "Отсутствует гнездо"
                },
                enchanting: {
                    name: "Наложение чар",
                    tooltip: "Не зачаровано"
                },
                engineering: {
                    name: "Инженерное дело",
                    tooltip: "Нет улучшения"
                },
                inscription: {
                    name: "Начертание",
                    tooltip: "Не зачаровано"
                },
                leatherworking: {
                    name: "Кожевенное дело",
                    tooltip: "Не зачаровано"
                }
            },
            talents: {
                specTooltip: {
                    title: "Специализация",
                    primary: "Основная:",
                    secondary: "Второстепенная:",
                    active: "Активная"
                }
            },
            stats: {
                toggle: {
                    all: "Показать все характеристики",
                    core: "Показать только основные характеристики"
                },
                increases: {
                    attackPower: "Увеличивает силу атаки на {0}.",
                    critChance: "Увеличивает шанс критического удара {0}%.",
                    spellCritChance: "Увеличивает шанс нанесения критического урона магией на {0}%.",
                    health: "Увеличивает здоровье на {0}.",
                    mana: "Увеличивает количество маны на {0}.",
                    manaRegen: "Увеличивает восполнение маны на {0} ед. каждые 5 сек., пока не произносятся заклинания.",
                    meleeDps: "Увеличивает урон, наносимый в ближнем бою, на {0} ед. в секунду.",
                    rangedDps: "Увеличивает урон, наносимый в дальнем бою, на {0} ед. в секунду.",
                    petArmor: "Увеличивает броню питомца на {0} ед.",
                    petAttackPower: "Увеличивает силу атаки питомца на {0} ед.",
                    petSpellDamage: "Увеличивает урон от заклинаний питомца на {0} ед.",
                    petAttackPowerSpellDamage: "Увеличивает силу атаки питомца на {0} ед. и урон от его заклинаний на {1} ед."
                },
                decreases: {
                    damageTaken: "Снижает получаемый физический урон на {0}%.",
                    enemyRes: "Снижает сопротивляемость противника на {0} ед.",
                    dodgeParry: "Снижает вероятность того, что ваш удар будет парирован или от вашего удара уклонятся, на {0}%."
                },
                noBenefits: "Не предоставляет бонусов вашему классу.",
                beforeReturns: "(До снижения действенности повторяющихся эффектов)",
                damage: {
                    speed: "Скорость атаки (сек.):",
                    damage: "Урон:",
                    dps: "Урон в сек.:"
                },
                averageItemLevel: {
                    title: "Уровень предмета {0}",
                    description: "Средний уровень вашего лучшего снаряжения. С его повышением вы сможете вставать в очередь в более сложные для прохождения подземелья."
                },
                health: {
                    title: "Здоровье {0}",
                    description: "Максимальный запас здоровья. Когда запас здоровья падает до нуля, вы погибаете."
                },
                mana: {
                    title: "Мана {0}",
                    description: "Максимальный запас маны. Мана расходуется на произнесение заклинаний."
                },
                rage: {
                    title: "Ярость {0}",
                    description: "Максимальный запас ярости. Ярость расходуется при применении способностей и накапливается, когда персонаж атакует врагов или получает урон."
                },
                focus: {
                    title: "Концентрация {0}",
                    description: "Максимальный уровень концентрации. Концентрация понижается при применении способностей и повышается со временем."
                },
                energy: {
                    title: "Энергия {0}",
                    description: "Максимальный запас энергии. Энергия расходуется при применении способностей и восстанавливается со временем."
                },
                runic: {
                    title: "Сила рун {0}",
                    description: "Максимальный запас силы рун."
                },
                strength: {
                    title: "Сила{0}"
                },
                agility: {
                    title: "Ловкость {0}"
                },
                stamina: {
                    title: "Выносливость {0}"
                },
                intellect: {
                    title: "Интеллект {0}"
                },
                spirit: {
                    title: "Дух {0}"
                },
                mastery: {
                    title: "Искусность {0}",
                    description: "Рейтинг искусности {0} увеличивает значение искусности на {1} ед.",
                    unknown: "Вы должны сперва изучить искусность у учителя.",
                    unspecced: "Выберите специализацию, чтобы активировать бонус рейтинга искусности. "
                },
                meleeDps: {
                    title: "Урон в секунду"
                },
                meleeAttackPower: {
                    title: "Сила атаки в ближнем бою {0}"
                },
                meleeSpeed: {
                    title: "Скорость атаки в ближнем бою {0}"
                },
                meleeHaste: {
                    title: "Рейтинг скорости в ближнем бою {0}%",
                    description: "Рейтинг скорости {0} увеличивает скорость атаки на {1}%.",
                    description2: "Увеличивает скорость атаки в ближнем бою."
                },
                meleeHit: {
                    title: "Рейтинг меткости в ближнем бою {0}%",
                    description: "Рейтинг меткости {0} увеличивает шанс попадания на {1}%."
                },
                meleeCrit: {
                    title: "Рейтинг критического удара в ближнем бою {0}%",
                    description: "Рейтинг критического удара {0} увеличивает шанс нанести критический удар {1}%.",
                    description2: "Шанс нанести дополнительный урон в ближнем бою."
                },
                expertise: {
                    title: "Мастерство {0}",
                    description: "Рейтинг мастерства {0} увеличивает значение мастерства на {1} ед."
                },
                rangedDps: {
                    title: "Урон в секунду"
                },
                rangedAttackPower: {
                    title: "Сила атаки в дальнем бою {0}"
                },
                rangedSpeed: {
                    title: "Скорость атаки в дальнем бою {0}"
                },
                rangedHaste: {
                    title: "Рейтинг скорости в дальнем бою {0}%",
                    description: "Рейтинг скорости {0} увеличивает скорость атаки на {1}%.",
                    description2: "Увеличивает скорость атаки в дальнем бою."
                },
                rangedHit: {
                    title: "Рейтинг меткости в дальнем бою {0}%",
                    description: "Рейтинг меткости {0} увеличивает шанс попадания на {1}%."
                },
                rangedCrit: {
                    title: "Рейтинг критического удара в дальнем бою {0}%",
                    description: "Рейтинг критического удара {0} увеличивает шанс нанести критический удар {1}%.",
                    description2: "Шанс нанести дополнительный урон в дальнем бою."
                },
                spellPower: {
                    title: "Сила заклинаний {0}",
                    description: "Увеличивает урон и исцеляющую силу заклинаний."
                },
                spellHaste: {
                    title: "Рейтинг скорости произнесения заклинаний {0}%",
                    description: "Рейтинг скорости {0} увеличивает скорость произнесения заклинаний на {1}%.",
                    description2: "Увеличивает скорость произнесения заклинаний."
                },
                spellHit: {
                    title: "Вероятность попадания заклинанием {0}%",
                    description: "Рейтинг меткости {0} увеличивает шанс попадания на {1}%."
                },
                spellCrit: {
                    title: "Вероятность критического эффекта заклинания {0}%",
                    description: "Рейтинг критического удара {0} увеличивает шанс нанести критический удар {1}%.",
                    description2: "Шанс нанести заклинанием дополнительный урон или исцеление."
                },
                spellPenetration: {
                    title: "Проникающая способность заклинаний {0}"
                },
                manaRegen: {
                    title: "Восполнение маны",
                    description: "{0} ед. маны восполняется раз в 5 сек. вне боя."
                },
                combatRegen: {
                    title: "Восполнение в бою",
                    description: "{0} ед. маны восполняется раз в 5 сек. в бою."
                },
                armor: {
                    title: "Броня {0}"
                },
                dodge: {
                    title: "Шанс уклонения {0}%",
                    description: "Рейтинг уклонения{0} увеличивает шанс уклониться от удара на {1}%."
                },
                parry: {
                    title: "Шанс парировать удар {0}%",
                    description: "Рейтинг парирования {0} увеличивает шанс парировать удар на {1}%."
                },
                block: {
                    title: "Шанс блокирования {0}%",
                    description: "Рейтинг блокирования {0} увеличивает шанс блокировать удар на {1}%.",
                    description2: "Блокирование останавливает {0}% наносимого вам урона."
                },
                resilience: {
                    title: "Устойчивость {0}",
                    description: "Снижает {0}% урона, наносимого вам другими игроками и их питомцами или прислужниками."
                },
                arcaneRes: {
                    title: "Сопротивление тайной магии {0}",
                    description: "Снижает урон от тайной магии в среднем на {0}%."
                },
                fireRes: {
                    title: "Сопротивление магии огня {0}",
                    description: "Снижает урон от магии огня в среднем на {0}%."
                },
                frostRes: {
                    title: "Сопротивление магии льдя {0}",
                    description: "Снижает урон от магии льдя в среднем на {0}%."
                },
                natureRes: {
                    title: "Сопротивление силам природы {0}",
                    description: "Снижает урон от сил природы в среднем на {0}%."
                },
                shadowRes: {
                    title: "Сопротивление темной магии {0}",
                    description: "Снижает урон от темной магии в среднем на {0}%."
                }
            },
            recentActivity: {
                subscribe: "Подписаться на эту ленту новостей"
            },
            raid: {
                tooltip: {
                    normal: "(норм.)",
                    heroic: "(героич.)",
                    players: "{0} игроков",
                    complete: "{0}% завершено ({1}/{2})",
                    optional: "(на выбор)",
                    expansions: {
                            0: "Классика",
                            1: "The Burning Crusade",
                            2: "Wrath of the Lich King",
                            3: "Cataclysm"
                    }
                },
                expansions: {
                        0: "Классика",      
                        1: "The Burning Crusade",      
                        2: "Wrath of the Lich King",      
                        3: "Cataclysm"      
                }
            }
        };
    //]]>