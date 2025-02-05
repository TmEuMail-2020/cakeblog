<?php
declare(strict_types=1);
//phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace -- legacy cakephp2 code, cake comes from lib folder - not PSR12 compliant
class PostsController extends AppController
{
    public $helpers = ['Html', 'Form', 'Flash'];
    public $component = [
        'Flash',
        'Auth' => ['className' => 'MyAuth'],
        'Session',
        'Cookie',
    ];

    public function index()
    {
        $this->set('posts', $this->Post->find('all'));
    }

    public function view($id = null)
    {
        // phpinfo();
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);

        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }

        $this->set('post', $post);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Post->create();

            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been saved.'));

                return $this->redirect('https://8765-' . substr(getenv('GITPOD_WORKSPACE_URL'), 8));
            }

            $this->Flash->error(__('Unable to add your post.'));
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);

        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Post->id = $id;

            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been updated.'));

                return $this->redirect('https://8765-' . substr(getenv('GITPOD_WORKSPACE_URL'), 8));
            }

            $this->Flash->error(__('Unable to update your post.'));
        }

        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }

    public function delete($id)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Post->delete($id)) {
            $this->Flash->success(__('The post with id: %s has been delete.', h($id)));
        } else {
            $this->Flash->error(__('The post with id: %s could not be delete.', h($id)));
        }

        return $this->redirect('https://8765-' . substr(getenv('GITPOD_WORKSPACE_URL'), 8));
    }

    public function my_action()
    {
        $this->render('Users.UserDetails/custom_file');
    }
}
