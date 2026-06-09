<?php
/**
 * =============================================================
 * FILE: controllers/admin/AdminCategoryController.php
 * MỤC ĐÍCH: Quản lý ngành nghề (CRUD)
 * =============================================================
 */
class AdminCategoryController extends Controller
{
    public function index(): void
    {
        AdminMiddleware::handle();
        $categories = (new Category())->getAll();
        $this->render('admin/categories/index', [
            'categories' => $categories,
            'flash'      => $this->getFlash(),
        ]);
    }

    public function createForm(): void
    {
        AdminMiddleware::handle();
        $this->render('admin/categories/create', ['flash' => $this->getFlash()]);
    }

    public function create(): void
    {
        AdminMiddleware::handle();

        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            $this->setFlash('error', 'Tên ngành nghề không được để trống.');
            $this->redirect('/admin/categories/create');
        }

        $catModel = new Category();
        if ($catModel->nameExists($name)) {
            $this->setFlash('error', 'Ngành nghề này đã tồn tại.');
            $this->redirect('/admin/categories/create');
        }

        $catModel->create($name)
            ? $this->setFlash('success', 'Thêm ngành nghề thành công!')
            : $this->setFlash('error', 'Thêm ngành nghề thất bại.');

        $this->redirect('/admin/categories');
    }

    public function editForm(): void
    {
        AdminMiddleware::handle();

        $id  = (int) ($_GET['id'] ?? 0);
        $cat = (new Category())->findById($id);

        if (!$cat) {
            $this->setFlash('error', 'Không tìm thấy ngành nghề.');
            $this->redirect('/admin/categories');
        }

        $this->render('admin/categories/edit', [
            'category' => $cat,
            'flash'    => $this->getFlash(),
        ]);
    }

    public function edit(): void
    {
        AdminMiddleware::handle();

        $id   = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $this->setFlash('error', 'Tên ngành nghề không được để trống.');
            $this->redirect('/admin/categories/edit?id=' . $id);
        }

        $catModel = new Category();
        if ($catModel->nameExists($name, $id)) {
            $this->setFlash('error', 'Tên ngành nghề đã tồn tại.');
            $this->redirect('/admin/categories/edit?id=' . $id);
        }

        $catModel->update($id, $name)
            ? $this->setFlash('success', 'Cập nhật ngành nghề thành công!')
            : $this->setFlash('error', 'Cập nhật thất bại.');

        $this->redirect('/admin/categories');
    }

    public function delete(): void
    {
        AdminMiddleware::handle();

        $id = (int) ($_POST['id'] ?? 0);

        (new Category())->delete($id)
            ? $this->setFlash('success', 'Xóa ngành nghề thành công!')
            : $this->setFlash('error', 'Xóa thất bại.');

        $this->redirect('/admin/categories');
    }
}
