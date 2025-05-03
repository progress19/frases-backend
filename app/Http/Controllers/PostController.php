<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostController extends Controller
{
    public function viewPosts() {
        $temas = Tema::where(['estado' => 1])->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        return view('admin.posts.view_posts')->with(compact('temas'));
    }
    
    /********************************************************************************************/
    /************************************ GET DATA **********************************************/
    
    public function getData() {
        $posts = Post::select();
        return Datatables::of($posts)
        ->editColumn('id', function ($post) {
            return "<a class='btn-table hvr-grow' href='edit-post/$post->id'>$post->id</a>"; 
        })
        ->editColumn('titulo', function ($post) {
            return "<a title='Clic para editar...' href='edit-post/$post->id'>".Str::limit($post->titulo, 80)."</a>"; 
        })
        ->editColumn('fecha_publicacion', function ($post) {
            return Carbon::parse($post->fecha_publicacion)->format('d/m/Y');
        })
        ->editColumn('tiempo_lectura', function ($post) {
            return $post->tiempo_lectura . ' min';
        })
        ->editColumn('estado', function ($post) {
            $checked = $post->estado ? 'checked' : '';
            $model = "Post";
            return '<input type="checkbox" '.$checked.' class="estado-chk" onchange="elif('.$post->id.', \''.$model.'\')" />';
        })
        ->editColumn('acciones', function ($post) {
            return '<a href="delete-post/'.$post->id.'" class="delReg"><i class="fa fa-trash" title="Eliminar registro"></i></a>';
        })
        ->setRowAttr([ 'id' => function ($post) { return $post->id; } ])
        ->rawColumns(['id', 'titulo', 'estado', 'acciones'])
        ->make(true);
    }
    
    public function getDataByTema(Request $request) 
    {
        $tema_id = $request->get('tema');
        
        $posts = Post::select('posts.*')
            ->when($tema_id, function($query) use ($tema_id) {
                return $query->join('posts_pivot_temas', 'posts.id', '=', 'posts_pivot_temas.post_id')
                            ->where('posts_pivot_temas.tema_id', $tema_id);
            });

        return Datatables::of($posts)
        ->editColumn('id', function ($post) {
            return "<a class='btn-table hvr-grow' href='edit-post/$post->id'>$post->id</a>"; 
        })
        ->editColumn('titulo', function ($post) {
            return "<a title='Clic para editar...' href='edit-post/$post->id'>".Str::limit($post->titulo, 80)."</a>"; 
        })
        ->editColumn('fecha_publicacion', function ($post) {
            return Carbon::parse($post->fecha_publicacion)->format('d/m/Y');
        })
        ->editColumn('tiempo_lectura', function ($post) {
            return $post->tiempo_lectura . ' min';
        })
        ->editColumn('estado', function ($post) {
            $checked = $post->estado ? 'checked' : '';
            $model = "Post";
            return '<input type="checkbox" '.$checked.' class="estado-chk" onchange="elif('.$post->id.', \''.$model.'\')" />';
        })
        ->editColumn('acciones', function ($post) {
            return '<a href="delete-post/'.$post->id.'" class="delReg"><i class="fa fa-trash" title="Eliminar registro"></i></a>';
        })
        ->setRowAttr([ 'id' => function ($post) { return $post->id; } ])
        ->rawColumns(['id', 'titulo', 'estado', 'acciones'])
        ->make(true);
    }
    
    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/
    
    public function editPost(Request $request, $id = null) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            /* save Temas */
            $datenow = Carbon::now();
            $post = Post::find($id)->temas()->detach();
            
            if ($request->temas) {
                $post = Post::find($id);
                foreach ($request->temas as $idtema) {
                    $post->temas()->attach($idtema, ['created_at' => $datenow]);
                }
            }
            
            Post::where(['id' => $id])->update([
                'titulo' => $data['titulo'],
                'subtitulo' => $data['subtitulo'],
                'contenido' => $data['contenido'],
                'fecha_publicacion' => $data['fecha_publicacion'],
                'tiempo_lectura' => $data['tiempo_lectura'],
            ]);
            
            return redirect('/admin/view-posts')->with('flash_message', 'Post actualizado correctamente...');
        }
        
        $temas = Tema::where(['estado' => 1])->orderBy('nombre', 'asc')->get();
        $post = Post::where(['id' => $id])->first();
        return view('admin.posts.edit_post')->with(compact('post', 'temas'));
    }
    
    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    
    public function addPost(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $post = new Post;
            $post->titulo = $data['titulo'];
            $post->subtitulo = $data['subtitulo'] ?? '';
            $post->contenido = $data['contenido'];
            $post->fecha_publicacion = $data['fecha_publicacion'];
            $post->tiempo_lectura = $data['tiempo_lectura'];
            $post->estado = 1;
            $post->save();
            
            /* Temas */
            $datenow = Carbon::now();
            
            if ($request->temas) {
                foreach ($request->temas as $idtema) {
                    $post->temas()->attach($idtema, ['created_at' => $datenow]);
                }
            }
            
            return redirect('/admin/view-posts')->with('flash_message', 'Post creado correctamente...');
        }
        
        $temas = Tema::where(['estado' => 1])->orderBy('nombre', 'asc')->get();
        return view('admin.posts.add_post')->with(compact('temas'));
    }
    
    /*********************************************************/
    /*                   D E L E T E                         */
    /*********************************************************/
    
    public function deletePost(Request $request, $id = null) {
        if (!empty($id)) {
            Post::where(['id' => $id])->delete();
            return redirect('/admin/view-posts')->with('flash_message', 'Post eliminado...');
        }
        return view('admin.posts.view_posts');
    }
}
