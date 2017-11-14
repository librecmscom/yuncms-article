<?php

namespace yuncms\article\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yuncms\article\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `yuncms\article\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'comments', 'supports', 'collections', 'views', 'is_top', 'is_best', 'user_id'], 'integer'],
            [['title', 'created_at', 'updated_at', 'published_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $date, $date + 3600 * 24]);
        }


        if ($this->updated_at !== null) {
            $date = strtotime($this->updated_at);
            $query->andFilterWhere(['between', 'updated_at', $date, $date + 3600 * 24]);
        }

        if ($this->published_at !== null) {
            $date = strtotime($this->published_at);
            $query->andFilterWhere(['between', 'published_at', $date, $date + 3600 * 24]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'comments' => $this->comments,
            'views' => $this->views,
            'supports' => $this->supports,
            'collections' => $this->collections,
            'is_top' => $this->is_top,
            'is_best' => $this->is_best,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
