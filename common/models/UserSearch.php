<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{

    public function attributes()
    {
        return array_merge(parent::attributes(),
            ['user_info.login_time', 'user_extend.gender', 'user_extend.post_id', 'user_extend.gender'], $this->likeColumnSearch()); // TODO: Change the autogenerated stub
    }

    /**
     * @return array
     * Create: 雨鱼
     */
    public function likeColumnSearch()
    {
        return ['user_extend.tel', 'user_extend.type', 'user_extend.entry_status', 'user_extend.entry_date', 'user_extend.education', 'user_info.login_ip', 'user_info.login_count'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $safe = ['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'user_info.login_time', 'user_extend.gender', 'user_extend.post_id', 'user_extend.gender'];
        $safe = array_merge($safe, $this->likeColumnSearch());
        return [
            [['id', 'status', 'created_at', 'updated_at', 'user_extend.tel', 'user_info.login_count', 'user_extend.type'], 'integer'],
            [$safe, 'safe'],
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

        $query = User::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['like', 'email', $this->email]);

        $query->join('LEFT JOIN', 'user_info', 'user_info.user_id = user.id');

        $query->leftJoin('user_extend', 'user.id = user_extend.user_id');
        $query->andFilterWhere(['=','user_extend.entry_status',$this->getAttribute('user_extend.entry_status')])
               ->andFilterWhere(['=','user_extend.gender',$this->getAttribute('user_extend.gender')])
               ->andFilterWhere(['in', 'user_extend.post_id', $this->getPostId($this->getAttribute('user_extend.post_id'))]);

        foreach ($this->likeColumnSearch() as $search) {
            $query->andFilterWhere(['like', $search, $this->getAttribute($search)]);
        }

        foreach($this->getAttributes() as $attribute=>$value) {
            $dataProvider->sort->attributes[$attribute] = [
                'asc' => [$attribute => SORT_ASC],
                'desc' => [$attribute => SORT_DESC]
            ];
        }

        return $dataProvider;
    }


    /**
     * @param $name
     * @return array|bool
     * Create: 雨鱼
     */
    public function getPostId($name)
    {
        if (!empty($name)) {
            $postId = Post::find()->where(['like', 'name', $name])->select('id')->all();

            $allId = array_map(function($value) {
                return $value->id;
            }, $postId);

            return $allId;
        }
    }


}