import { Component, OnInit, AfterViewInit } from '@angular/core';
import { Helper } from './helpers/helper';
import { UsusuService } from './modulos/kseg/servicios/ususu.service';
declare var $: any;
import { Ususu } from './modelos/ususu';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  // providers: [ UsusuService ]
})
export class AppComponent implements OnInit, AfterViewInit {
  title = 'app works!';
  public usuario: Ususu = new Ususu();
  public usuarios: Ususu[] = [];
  constructor( private _helper: Helper, private _ususuService: UsusuService ) {
    this._ususuService.get('')
    .subscribe(
            usuarios => {
              this.usuarios = usuarios;
              // console.log(this.usuarios);
            }
          );
  }
  ngOnInit() {
    if (this.usuario.NOMBRE === '') {
      $('body').attr('class', 'gray-bg');
    }
  }

  ngAfterViewInit() {
    const helper: Helper = this._helper;
    setTimeout(function() {
          // helper.notificacion('Mensaje de Prueba', 'Titulo del Mensaje');
          // helper.notificacion('Mensaje de Prueba', 'Titulo del Mensaje', 'error');
          // helper.notificacion('Mensaje de Prueba', 'Titulo del Mensaje', 'warning');
          // helper.notificacion('Mensaje de Prueba', 'Titulo del Mensaje', 'info');
      }, 1300, helper);
  }
}
