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


    public function actionTest()
    {
        $model = new Supplier();
        $testData = [];
        $t_status_list = ['ok', 'hold'];
        for ($i = 1; $i < 40; $i++) {
            $testData[] = [
                'name' => 'test_name_' . $i,
                'code' => 'C' . $i,
                't_status' => $t_status_list[array_rand($t_status_list)]
            ];
        }
        \Yii::$app->db->createCommand()->batchInsert($model::tableName(), ['name', 'code', 't_status'], $testData)->execute();
        \Yii::$app->getSession()->setFlash('success', '操作成功');
        return $this->redirect(['supplier/index']);
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
}
