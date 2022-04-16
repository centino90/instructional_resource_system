<?php

namespace Database\Factories;

use App\Models\TypologyStandard;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypologyStandardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypologyStandard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'enabled' => true,
            'verbs' => [
                'REMEMBER' => [
                    'DEFINE', 'DESCRIBE', 'LABEL', 'LIST', 'MATCH', 'RECALL', 'RECOGNIZE', 'STATE'
                ],
                'UNDERSTAND' => [
                    'CLASSIFY', 'COMPARE', 'DISCUSS', 'EXEMPLIFY', 'EXPLAIN', 'IDENTIFY', 'ILLUSTRATE', 'INFER', 'INTERPRET', 'PREDICT', 'REPORT', 'REVIEW', 'SUMMARIZE', 'TRANSLATE'
                ],
                'APPLY' => [
                    'CHANGE', 'CHOOSE', 'DEMONSTRATE', 'EXECUTE', 'IMPLEMENT', 'PREPARE', 'SOLVE', 'USE'
                ],
                'ANALYZE' => [
                    'ATTRIBUTE', 'DEBATE', 'DIFFERENTIATE', 'DISTINGUISH', 'EXAMINE', 'ORGANIZE', 'RESEARCH'
                ],
                'EVALUATE' => [
                    'APPRAISE', 'CHECK', 'CRITIQUE', 'JUDGE'
                ],
                'CREATE' => [
                    'COMPOSE', 'CONSTRUCT', 'DESIGN', 'DEVELOP', 'FORMULATE', 'GENERATE', 'INVENT', 'MAKE', 'ORGANIZE', 'PLAN', 'PRODUCE', 'PROPOSE'
                ],
                'PERCEIVE' => [
                    'DETECT', 'DIFFERENTIATE', 'DISTINGUISH', 'IDENTIFY', 'OBSERVE', 'RECOGNIZE', 'RELATE'
                ],
                'SET' => [
                    'ASSUME A STANCE', 'DISPLAY', 'PERFORM MOTOR SKILLS', 'POSITION THE BODY', 'PROCEED', 'SHOW'
                ],
                'RESPOND AS GUIDED' => [
                    'COPY', 'DUPLICATE', 'MITATE', 'OPERATE UNDER SUPERVISION', 'PRACTICE', 'REPEAT', 'REPRODUCE'
                ],
                'ACT' => [
                    'ASSEMBLE', 'CALIBRATE', 'COMPLETE WITH CONFIDENCE', 'CONDUCT', 'CONSTRUCT', 'DEMONSTRATE', 'DISMANTLE', 'FIX', 'EXECUTE', 'IMPROVE EFFICIENCY', 'MAKE', 'MANIPULATE', 'MEASURE', 'MEND', 'ORGANIZE', 'PRODUCE'
                ],
                'RESPOND OVERTLY' => [
                    'ACT HABITUALLY', 'CONTROL', 'DIRECT', 'GUIDE', 'MANAGE', 'PERFORM'
                ],
                'ADAPT' => [
                    'ALTER', 'CHANGE', 'REARRANGE', 'REORGANIZE', 'REVISES'
                ],
                'RECEIVE' => [
                    'ACKNOWLEDGE', 'CHOOSE', 'DEMONSTRATE AWARENESS', 'DEMONSTRATE TOLERANCE', 'LOCATE', 'SELECT'
                ],
                'RESPOND' => [
                    'ANSWER', 'COMMUNICATE', 'COMPLY', 'CONTRIBUTE', 'COOPERATE', 'DISCUSS', 'PARTICIPATE WILLINGLY', 'VOLUNTEER'
                ],
                'VALUE' => [
                    'ADOPT', 'ASSUME RESPONSIBILITY', 'BEHAVE ACCORDING TO', 'CHOOSE', 'COMMIT', 'EXPRESS', 'INITIATE', 'JUSTIFY', 'PROPOSE', 'SHOW CONCERN', 'USE RESOURCES TO'
                ],
                'ORGANIZE' => [
                    'BUILD', 'COMPOSE', 'CONSTRUCT', 'CREATE', 'DESIGN', 'ORIGINATE', 'MAKE', 'ADAPT', 'ADJUST', 'ARRANGE', 'BALANCE', 'CLASSIFY', 'CONCEPTUALIZE', 'FORMULATE', 'PREPARE', 'RANK', 'THEORIZE'
                ],
                'CHARACTERIZE' => [
                    'ACT UPON', 'ADVOCATE', 'DEFEND', 'EXEMPLIFY', 'INFLUENCE', 'PERFORM', 'PRACTICE', 'SERVE', 'SUPPORT'
                ]
            ]
        ];
    }
}
