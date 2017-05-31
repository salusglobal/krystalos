import { TestBed, inject } from '@angular/core/testing';

import { CiaService } from './cia.service';

describe('CiaService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CiaService]
    });
  });

  it('should be created', inject([CiaService], (service: CiaService) => {
    expect(service).toBeTruthy();
  }));
});
