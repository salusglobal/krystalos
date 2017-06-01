import { Component, OnInit } from '@angular/core';
import { environment } from '../../../../environments/environment';
import { Helper } from '../../../helpers/helper';
import { CiaService } from '../servicios/cia.service';
import { Cia } from '../../../modelos/cia';
import { AutenticacionService } from '../servicios/autenticacion.service';
@Component({
  selector: 'app-ingresar',
  templateUrl: './ingresar.component.html',
  styleUrls: ['./ingresar.component.css'],
  providers: [ CiaService ]
})
export class IngresarComponent implements OnInit {
  public env = environment;
  public compania = '';
  public usuario = '';
  public clave = '';
  public companias: Cia[] = [];
  public companiaElegida: Cia = new Cia();
  private formValido = false;
  constructor(
    private _helper: Helper,
    private _ciaService: CiaService,
    private _autenticacionService: AutenticacionService
  ) {

   }

  ngOnInit() {
    this._ciaService.get(this.compania)
      .subscribe(
        companias => {
          this.companias = companias;
          // console.log(this.companias);
        }
      );
  }
  private validaciones() {
    if (this.companiaElegida.COMPANIA === '') {
      this._helper.notificacion('Debes ingresar el código de la compañía', 'Krystalos', 'error');
      return false;
    }
    if (this.usuario === '') {
      this._helper.notificacion('Debes ingresar el usuario', 'Krystalos', 'error');
      return false;
    }
    if (this.clave === '') {
      this._helper.notificacion('Debes ingresar la contraseña', 'Krystalos', 'error');
      return false;
    }

    this.formValido = true;
  }
  onSubmit() {
    this.validaciones();
    if (!this.formValido) {
      return false;
    }
    // console.log('Compania Elegida: ');
    // console.log(this.companiaElegida);
    // let retornar: boolean;
    // retornar = true;
    // if (retornar) {
    //   return false;
    // }
    this._autenticacionService.login(this.companiaElegida, this.usuario, this.clave)
      .subscribe(
        success => {
          if (success) {
            location.reload();
          }else {
            // this._helper.notificacion('Usuario y Contraseña no Coinciden', 'Ingreso al sistema', 'info');
          }
        }
      );

    return false;
  }

  public getCompania() {
    this.companiaElegida = new Cia();
    this.companias.forEach(compania => {
      if (compania.COMPANIA.toUpperCase() === this.compania.toUpperCase()) {
        this.companiaElegida = compania;
      }
    });
  }

}
