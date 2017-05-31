import { Injectable } from '@angular/core';
import { Ususu } from './../../../modelos/ususu';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { Http, Headers, Response, RequestOptions } from '@angular/http';
import { environment } from '../../../../environments/environment';
import { Helper } from '../../../helpers/helper';
@Injectable()
export class UsusuService {

  constructor(
    private _http: Http, private _helper: Helper
  ) { }

  get(usuario: string): Observable<Ususu[]> {
    const _url = environment.apiurl + '/ususu/usuarios/' + usuario;
    return this._http.get(_url)
      .map((response: Response) => {
        // console.log(response.json());
        return response.json().result;
      })
      .catch(err => this.handleError(err))
      ;
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
    this._helper.notificacion(errMsg, 'Error', 'error');
    // if(errorCode===401){
    // this._router.navigate(['salir']);
    // }
    return Observable.throw(errMsg);
  }
}
