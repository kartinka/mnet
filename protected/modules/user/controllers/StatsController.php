<?php

class StatsController extends Controller
{
	public $defaultAction = 'all';
	public $layout='//layouts/inner';
    private $_user;

    public function init() {
        $user_controller = Yii::app()->createController('User');
        $this->_user = $user_controller[0]->loadModel(Yii::app()->user->id);
    }

    private function getStatsData($conditions = '')
    {
        $conditions = 't.author_id = ' . Yii::app()->user->id . $conditions;

        $answers = Answer::model()->with('questions')->findAll(array('condition' => $conditions));

        $stats = new stdClass(); //of objects
        $stats->answers = array();
        $stats->totals = array();
        $institutions = array();

        $stats->totals['views'] = 0;
        $stats->totals['answers'] = 0;
        $stats->totals['people'] = 0;
        $stats->totals['institutions'] = 0;

        foreach ($answers as $a_k => $a_v) {
            $answer = new stdClass();

            $answer->views = $a_v->questions->viewed;
            $answer->question_id = $a_v->questions->id;
            $answer->question_text = $a_v->questions->text;
            $answer->answer_text = $a_v->text;
            $user_number = 0;
            $jobs_number = 0;
            $answer->jobs = array();
            foreach ($a_v->questions->question_viewed as $q_k => $q_v) {
                $user_number += 1;
                foreach ($q_v->current_job as $j_k => $j_v) {
                    if (!in_array($j_v->location, $answer->jobs)) {
                        $jobs_number += 1;
                        $answer->jobs[] = $j_v->location;
                        $institutions[] = $j_v->location;
                    }
                }
            }
            $answer->user_number = $user_number;
            $answer->jobs_number = $jobs_number;
            $stats->answers[] = $answer;
            $stats->totals['answers'] += 1;
            $stats->totals['views'] += $answer->views;
            $stats->totals['people'] += $user_number;
            //$stats->totals['institutions'] += count (array_unique($answer->)); //$jobs_number;
        }

        $stats->totals['institutions'] += count (array_unique($institutions));


        $invitees = User::model()->with('profile')->findAll(array('select' => '*, rand() as rand', 'order' => 'rand', 'limit' =>5));

        $stats_provider =  new CArrayDataProvider($stats->answers,
            array('keyField' =>'question_id',
                'pagination' => array(
                    'pageSize' => 3
                )));



        return (array($invitees, $stats_provider, $stats->totals));

    }

	public function actionAll()
	{
        list($invitees, $stats_answers, $stats_totals) = $this->getStatsData();

        $this->render('all',
            array(
                'title' => 'all',
                'model' => $this->_user,
                //'answers' => $answers,
                'invitees' => $invitees,
                'stats_answers' => $stats_answers,
                'stats_totals' => $stats_totals
            ));

	}

    public function actionWeek()
    {
        list($invitees, $stats_answers, $stats_totals) = $this->getStatsData(' AND t.create_at > DATE_SUB(NOW(), INTERVAL 1 WEEK)');

        $this->render('all',
            array(
                'title' => 'week',
                'model' => $this->_user,
                //'answers' => $answers,
                'invitees' => $invitees,
                'stats_answers' => $stats_answers,
                'stats_totals' => $stats_totals
            ));

    }

    public function actionMonth()
    {
        list($invitees, $stats_answers, $stats_totals) = $this->getStatsData(' AND t.create_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)');

        $this->render('all',
            array(
                'title' => 'month',
                'model' => $this->_user,
                //'answers' => $answers,
                'invitees' => $invitees,
                'stats_answers' => $stats_answers,
                'stats_totals' => $stats_totals
            ));

    }

    public function loadModel($id)
    {
        $model=UserNotifications::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
	
}