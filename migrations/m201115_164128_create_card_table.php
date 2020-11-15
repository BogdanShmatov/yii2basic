<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card}}`.
 */
class m201115_164128_create_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card}}', [
            'id' => $this->primaryKey(),
            'card_number' => $this->string(),
            'card_month' => $this->integer(),
            'card_year' => $this->integer(),
            'card_cvc' => $this->integer(),
            'card_balance' => $this->integer(),
            'card_Name' => $this->string(),
        ]);

        $this->batchInsert('{{%card}}',
            ['card_number',
                'card_month',
                'card_year',
                'card_cvc',
                'card_balance',
                'card_Name',
                ], [

                // Success

                // Visa
                ['4242424242424242',
                    '12',
                    '24',
                    '123',
                    '150000',
                    'Bogdan Shmatov',
                ],
                // MasterCard
                ['5555555555554444',
                    '12',
                    '24',
                    '123',
                    '1023000',
                    'Anton Cha',
                ],
                // Insufficient Funds

                // Visa
                ['4000000000000002',
                    '12',
                    '24',
                    '123',
                    '0',
                    'Kii Falon',
                ],
                // MasterCard
                ['5100000000000412',
                    '12',
                    '24',
                    '123',
                    '0',
                    'Daniil Romka',
                ],
                // Invalid Card

                //Visa
                ['4222222222222220',
                    '12',
                    '24',
                    '123',
                    '0',
                    'Lia Dan',
                ],
                // Expired Card

                // Visa
                ['4000000000000069',
                    '12',
                    '24',
                    '123',
                    '10000',
                    'Mike Gloom',
                ],
                // Unknown Failure

                // MasterCard
                ['5124990000000002',
                    '12',
                    '24',
                    '123',
                    '11250000',
                    'Mister Mo',
                ],
                // CVV Match Fail

                // Visa
                ['4003830171874018',
                    '12',
                    '24',
                    '123',
                    '1102300',
                    'Lisa Neeta',
                ],


            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%card}}');
    }
}
