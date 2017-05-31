import { TestBed, inject } from '@angular/core/testing';

import { UsusuService } from './ususu.service';

describe('UsusuService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [UsusuService]
    });
  });

  it('should be created', inject([UsusuService], (service: UsusuService) => {
    expect(service).toBeTruthy();
  }));
});
