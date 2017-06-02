import { Component, OnInit } from '@angular/core';
import { environment } from '../../../../environments/environment';

@Component({
  selector: 'app-navbar-static-top',
  templateUrl: './navbar-static-top.component.html',
  styleUrls: ['./navbar-static-top.component.css']
})
export class NavbarStaticTopComponent implements OnInit {
  private app = environment;
  constructor() { }

  ngOnInit() {
  }

  public logOut() {
    // localStorage.removeItem(environment.currentuser);
    localStorage.removeItem(environment.currentuser);
  }

}
