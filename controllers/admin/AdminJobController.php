<?php
/**
 * =============================================================
 * FILE: controllers/admin/AdminJobController.php
 * MỤC ĐÍCH: Quản lý tin tuyển dụng (CRUD)
 * =============================================================
 */
class AdminJobController extends Controller
{
    public function index(): void
    {
        AdminMiddleware::handle();
        $jobs = (new Job())->getAll();
        $this->render('admin/jobs/index', [
            'jobs'  => $jobs,
            'flash' => $this->getFlash(),
        ]);
    }

    public function createForm(): void
    {
        AdminMiddleware::handle();
        $categories = (new Category())->getAllSimple();
        $this->render('admin/jobs/create', [
            'categories' => $categories,
            'flash'      => $this->getFlash(),
        ]);
    }

    public function create(): void
    {
        AdminMiddleware::handle();

        $data = $this->extractJobData($_POST);

        if (empty($data['title']) || empty($data['company']) || empty($data['category_id'])) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ các trường bắt buộc.');
            $this->redirect('/admin/jobs/create');
        }

        (new Job())->create($data)
            ? $this->setFlash('success', 'Thêm tin tuyển dụng thành công!')
            : $this->setFlash('error', 'Thêm tin thất bại.');

        $this->redirect('/admin/jobs');
    }

    public function editForm(): void
    {
        AdminMiddleware::handle();

        $id  = (int) ($_GET['id'] ?? 0);
        $job = (new Job())->findById($id);

        if (!$job) {
            $this->setFlash('error', 'Không tìm thấy tin tuyển dụng.');
            $this->redirect('/admin/jobs');
        }

        $categories = (new Category())->getAllSimple();
        $this->render('admin/jobs/edit', [
            'job'        => $job,
            'categories' => $categories,
            'flash'      => $this->getFlash(),
        ]);
    }

    public function edit(): void
    {
        AdminMiddleware::handle();

        $id   = (int) ($_POST['id'] ?? 0);
        $data = $this->extractJobData($_POST);

        if (empty($data['title']) || empty($data['company']) || empty($data['category_id'])) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ các trường bắt buộc.');
            $this->redirect('/admin/jobs/edit?id=' . $id);
        }

        (new Job())->update($id, $data)
            ? $this->setFlash('success', 'Cập nhật tin tuyển dụng thành công!')
            : $this->setFlash('error', 'Cập nhật thất bại.');

        $this->redirect('/admin/jobs');
    }

    public function delete(): void
    {
        AdminMiddleware::handle();

        $id = (int) ($_POST['id'] ?? 0);

        (new Job())->delete($id)
            ? $this->setFlash('success', 'Xóa tin tuyển dụng thành công!')
            : $this->setFlash('error', 'Xóa thất bại.');

        $this->redirect('/admin/jobs');
    }

    /**
     * Helper: lấy dữ liệu job từ POST và làm sạch
     */
    private function extractJobData(array $post): array
    {
        return [
            'category_id'  => (int) ($post['category_id']  ?? 0),
            'title'        => trim($post['title']           ?? ''),
            'company'      => trim($post['company']         ?? ''),
            'salary'       => trim($post['salary']          ?? ''),
            'location'     => trim($post['location']        ?? ''),
            'description'  => trim($post['description']     ?? ''),
            'requirements' => trim($post['requirements']    ?? ''),
            'benefits'     => trim($post['benefits']        ?? ''),
            'deadline'     => $post['deadline']             ?? null,
            'status'       => in_array($post['status'] ?? '', ['active', 'closed']) ? $post['status'] : 'active',
        ];
    }
}
