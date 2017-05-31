import { Injectable } from '@angular/core';
import { Ususu as Model } from '../../../modelos/ususu';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { Http, Headers, Response, RequestOptions } from '@angular/http';
import { environment } from '../../../../environments/environment';
import { Helper } from '../../../helpers/helper';
@Injectable()
export class AutenticacionService {
  public usuario: Model = new Model();
  constructor(
    private _http: Http,
    private _helper: Helper
  ) { }
  /**
   * login
   */
  public login(compania: string, usuario: string, clave: string): Observable<boolean> {
    const json = JSON.stringify({ compania: compania, usuario: usuario, clave: clave });
    const params = 'json=' + json;
    const headers = new Headers({
        'Content-Type': 'application/x-www-form-urlencoded'
      });
    return this._http.post(environment.apiurl + '/kseg/autenticar', params, {headers: headers} )
      .map(
        (response: Response )  => {
          // console.log(response.json());
          this.extractData(response);
          return false;
        }
      )
      .catch(err => this.handleError(err))
      ;

  }

  public extractData(res: Response, displayerror: boolean = true) {
    const body = res.json();
    console.log(body);

    // Actualizar token
    if ( body.token != null) {
      this.usuario.TOKEN = body.token;
    }
    if (body.status !== 200) {
      this._helper.notificacion(body.message, body.statusText, 'error');
    }
    //Si ha habido un error lanzar mensaje
    // if(body.error&&displayerror){
      // this._helper.notificationToast(body.error,"Error","error");
    // }

    return body.result || { };
  }
  public handleError(error: Response | any) {
    let errMsg: string;
    let errorCode: number;
    if (error instanceof Response) {
      const body = error.json() || '';
      const err = body.error || JSON.stringify(body);
      errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
      errorCode = +error.status;
    } else {
      errMsg = error.message ? error.message : error.toString();
    }
    this._helper.notificacion(errMsg, error.statusText, 'error');
    // if(errorCode===401){
    // this._router.navigate(['salir']);
    // }
    return Observable.throw(errMsg);
  }
  public handleError2(error: Response | any) {
    let errMsg: string;
    console.log('Pruebas de Desarrollo');
    console.log(error);
    if (!error.ok) {
      errMsg = error._body.message;
       if (error instanceof Response) {
          const body = error.json() || '';
          const err = body.error || JSON.stringify(body);
          errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
        } else {
          errMsg = error.message ? error.message : error.toString();
        }
      this._helper.notificacion(errMsg, error.statusText, 'error');
    }

    return Observable.throw(errMsg);
  }
}
