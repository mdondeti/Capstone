package Tests;

import static org.testng.Assert.assertEquals;

import java.io.FileInputStream;

import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import Repos.LoginPage;
import Repos.hpiPage;
import Repos.threePanelPage;
import Repos.vitalSignsSectionPage;

public class HpiTest {
	
	private String hpiComment;
	@DataProvider(name="hpi")
	public static Object[][] dataInputFromExcel() throws Exception
	{
		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		 int i=0;
		 int j=0;
		 Object[][] DataCellValues;
		
		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
	System.out.println("got here excel");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("HPI");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
				}


			}
		}
		return DataCellValues;
	}

	
//	@AfterMethod
//	public void afetrClass()
//	{
//		 
//	driver.close();
//	
//			
//		
//}
//	
  @Test(dataProvider="hpi")
  public void testHPI(String uname,String pass,String Patient,String hpi,String value) throws Exception
  {
	  WebDriver driver = new FirefoxDriver();
	 
	  LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(uname);
		LoginPage.Password(driver).sendKeys(pass);
	LoginPage.Submit(driver).click();
		
	 
	driver.findElement(By.partialLinkText(Patient)).click();
	threePanelPage.hpiTab(driver).click();
	//
	Thread.sleep(5000);
	hpiComment=hpiPage.HPIComment(driver).getText();
	hpiPage.HPIComment(driver).sendKeys(hpi);
	
	System.out.println("got here");
	//comment saved
	hpiPage.HPISaveButton(driver).click();
	//back to dashboard and check if data exists
	vitalSignsSectionPage.backToDash(driver).click();
	driver.findElement(By.partialLinkText(Patient)).click();
	Thread.sleep(5000);
	threePanelPage.hpiTab(driver).click();
	
	assertEquals(hpiPage.HPIComment(driver).getText(), hpiComment +" "+ hpi);
	//click reset and see if the data is cleared
	hpiPage.HPIResetButton(driver).click();
	assertEquals(hpiPage.HPIComment(driver).getText(), "");
	//click on an nav item and dissmiss alert
	threePanelPage.MedicalHistory(driver).click();
	driver.switchTo().alert().dismiss();
	
	
	//check if landed on same page
	assertEquals(hpiPage.HPIComment(driver).getText(), hpiComment +" "+ hpi);
	hpiPage.HPISaveButton(driver).click();
	threePanelPage.MedicalHistory(driver).click();
	//driver.switchTo().alert().accept();
	
	threePanelPage.hpiTab(driver).click();	
	hpiPage.HPIResetButton(driver).click();
	threePanelPage.MedicalHistory(driver).click();
	//driver.switchTo().alert().accept();
	
	assertEquals(driver.getPageSource().contains("Social History"), true);
	driver.close();
  }
 
}
