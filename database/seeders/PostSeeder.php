<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::insert([
            ['title'=>'Instalar Fedora 40', 'content'=>'<p><strong>Fedora</strong> &nbsp;para propósitos generales. Es mantenida por una comunidad internacional de ingenieros, diseñadores y usuarios. Se caracteriza por su estabilidad, pero también por estar a la vanguardia en la adopción de software libre y&nbsp;</p><figure class="table"><table><tbody><tr><td>Fedora</td><td>Uno cero</td><td>De lujo</td></tr></tbody></table></figure><p>de código abierto. Cuenta con el patrocinio principal de <a href="https://es.wikipedia.org/wiki/Red_Hat">Red Hat</a> (subsidiaria de <a href="https://es.wikipedia.org/wiki/IBM">IBM</a> desde 2019), además de otras empresas de tecnologías de la información y fabricantes de equipos de cómputo como</p>', 'slug'=>'instalar-fedora-40', 'image'=>null, 'status'=>1, 'fc'=>'2024-08-24 15:16:21.000', 'user_id'=>1],
            ['title'=>'¿Qué hacer después de instalar Fedora?', 'content'=>'<h2>Introducción</h2><p>La versión 40 de Fedora ya está disponible para su instalación desde cero o bien su actualización <a href="https://blog.linuxitos.com/post/actualizar-fedora-39-a-40">https://blog.linuxitos.com/post/actualizar-fedora-39-a-40</a>, en éste pequeño artículo resumo algunas acciones y configuraciones que son necesarias después de instalar fedora desde cero.</p><blockquote><p>ES NECESARIO ESPECIFICAR QUE ÉSTE TUTORIAL ESTÁ ORIENTADO A FEDORA Y ESPECÍFICO CON EL ESCRITORIO DE GNOME.</p></blockquote><h2>Asignar contraseña a root</h2><p>A partir de la versión 29 de fedora, es necesario asignarle una contraseña al usuario root después de iniciar el SO, ya que durante la instalación no solicita la contraseña para el usuario root</p>', 'slug'=>'que-hacer-despues-de-instalar-fedora', 'image'=>null, 'status'=>2, 'fc'=>'2024-08-24 15:18:23.000', 'user_id'=>1],
            ['title'=>'Fedora 40 y Gnome 46', 'content'=>'<h2>Introducción</h2><p>La versión 40 de Fedora ya está disponible para su instalación desde cero o bien su actualización <a href="https://blog.linuxitos.com/post/actualizar-fedora-39-a-40">https://blog.linuxitos.com/post/actualizar-fedora-39-a-40</a>, en éste pequeño artículo resumo algunas acciones y configuraciones que son necesarias después de instalar fedora desde cero.</p><blockquote><p>ES NECESARIO ESPECIFICAR QUE ÉSTE TUTORIAL ESTÁ ORIENTADO A FEDORA Y ESPECÍFICO CON EL ESCRITORIO DE GNOME.</p></blockquote><h2>Asignar contraseña a root</h2><p>A partir de la versión 29 de fedora, es necesario asignarle una contraseña al usuario root después de iniciar el SO, ya que durante la instalación no solicita la contraseña para el usuario root</p>', 'slug'=>'fedora-40-y-gnome-46', 'image'=>null, 'status'=>1, 'fc'=>'2024-08-24 15:18:23.000', 'user_id'=>1],
            ['title'=>'Gnome 46', 'content'=>'<h2>Introducción</h2><p>La versión 40 de Fedora ya está disponible para su instalación desde cero o bien su actualización <a href="https://blog.linuxitos.com/post/actualizar-fedora-39-a-40">https://blog.linuxitos.com/post/actualizar-fedora-39-a-40</a>, en éste pequeño artículo resumo algunas acciones y configuraciones que son necesarias después de instalar fedora desde cero.</p><blockquote><p>ES NECESARIO ESPECIFICAR QUE ÉSTE TUTORIAL ESTÁ ORIENTADO A FEDORA Y ESPECÍFICO CON EL ESCRITORIO DE GNOME.</p></blockquote><h2>Asignar contraseña a root</h2><p>A partir de la versión 29 de fedora, es necesario asignarle una contraseña al usuario root después de iniciar el SO, ya que durante la instalación no solicita la contraseña para el usuario root</p>', 'slug'=>'gnome-46', 'image'=>null, 'status'=>2, 'fc'=>'2024-08-24 15:18:23.000', 'user_id'=>1],
        ]);
    }
}
