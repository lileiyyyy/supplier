<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierSearch;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $supplierSearch['SupplierSearch'] = $this->request->queryParams['SupplierSearch'] ?? [];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'supplierSearchParams' => http_build_query($supplierSearch)
        ]);
    }

    public function actionExport()
    {
        $searchModel = new SupplierSearch();
        $model = new Supplier();
        $params = $this->request->get();
        if (isset($params['isSelectAll']) && $params['isSelectAll'] == 'true') {
            $dataProvider = $searchModel->search($params, false);
            $data = $dataProvider->query->asArray()->all();
        } else {
            $ids = $params['ids'] ?? '';
            $ids = explode(',', $ids);
            $data = $model::find()->where(['id' => $ids])->asArray()->all();

        }
        if (empty($data)) {
            \Yii::$app->getSession()->setFlash('error', '待导出数据为空');
            return $this->redirect(['supplier/index']);

        }
        $header = $params['header'] ?? [];
        if (empty($header)) {
            \Yii::$app->getSession()->setFlash('error', '待导出字段为空');
            return $this->redirect(['supplier/index']);
        }
        $header = $params['header'] ?? [];
        $header = explode(',', $header);
        $this->exportSupplier('supplier', $header, $data);
        return ['msg' => '操作成功'];
    }


    function exportSupplier($title, $header, $data)
    {

        $spreadsheet = new Spreadsheet();

        $objSheet = $spreadsheet->getActiveSheet();  //获取当前操作sheet的对象
        $objSheet->setTitle($title);  //设置当前sheet的标题

        foreach ($header as $index => $item) {
            $objSheet->setCellValue(Coordinate::stringFromColumnIndex($index + 1) . "1", $item);
        }

        foreach ($data as $key => $values) {
            $key = $key + 2;
            $loop = 1;
            foreach ($values as $k => $v) {
                if (in_array($k, $header)) {
                    $objSheet->setCellValue(Coordinate::stringFromColumnIndex($loop) . $key, $v);
                }
                $loop++;
            }
        }
        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $title . date('Ymd') . '.csv');
        header('Cache-Control: max-age=0');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = new Csv($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    /**
     * Displays a single Supplier model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
